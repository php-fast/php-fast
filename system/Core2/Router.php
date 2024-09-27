<?php
namespace System\Core;
use System\Core\Middleware;
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Router {

    private $routes = [];

    /**
     * Đăng ký route GET
     */
    public function get($uri, $controller, $middleware = []) {
        $this->addRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Đăng ký route POST
     */
    public function post($uri, $controller, $middleware = []) {
        $this->addRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Đăng ký route PUT
     */
    public function put($uri, $controller, $middleware = []) {
        $this->addRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Đăng ký route DELETE
     */
    public function delete($uri, $controller, $middleware = []) {
        $this->addRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Thêm route vào danh sách routes
     */
    private function addRoute($method, $uri, $controller, $middleware = []) {
        $this->routes[$method][parse_uri($uri)] = [
            'controller' => $controller,
            'middleware' => $middleware
        ];
    }

    /**
     * Khớp URI với route và trả về thông tin controller, action, params, và middleware
     */
    public function match($uri, $method) {
        $uri = parse_uri($uri);

        // Kiểm tra từng route đã đăng ký để tìm khớp
        foreach ($this->routes[$method] as $routeUri => $route) {
            if (preg_match($this->convertToRegex($routeUri), $uri, $matches)) {
                array_shift($matches); // Loại bỏ khớp toàn bộ regex
                $controllerAction = $this->getControllerAction($route['controller'], $matches); 
                $controllerAction['middleware'] = $route['middleware'];
                return [
                    'controller' => $controllerAction[0],
                    'action' => $controllerAction[1],
                    'params' => $controllerAction[2],
                    'middleware' => $route['middleware'] // Trả về middleware nếu có
                ];
            }
        }

        // Kiểm tra nếu chỉ khớp controller (ví dụ: /admin hoặc /admin/index)
        $controller = explode('::', $route['controller'])[0];
        if ($this->isControllerRoute($routeUri, $uri, $controller)) {
            $controllerAction = $this->getControllerAction($route['controller'], []);
            return [
                'controller' => $controllerAction[0],
                'action' => $controllerAction[1] ?? 'index', // Mặc định action là 'index'
                'params' => [],
                'middleware' => $route['middleware'] // Trả về middleware nếu có
            ];
        }
        // Nếu không có route nào khớp, kiểm tra cấu trúc tự động "/Controller/Function"
        return $this->autoRoute($uri);
    }

    /**
     * Kiểm tra xem URL có khớp với controller và phương thức không (wildcard)
     */
    // private function isControllerRoute($routeUri, $uri, $controller) {
    //     // Kiểm tra nếu URI bắt đầu với routeUri (controller) và không có action cụ thể
    //     return strpos($uri, trim(parse_uri($routeUri), '/')) === 0 && strpos($uri, strtolower($controller)) !== false;
    // }
    /*
    private function isControllerRoute($routeUri, $uri, $controller) {
        // Loại bỏ dấu '\' khỏi tên controller và URI để thực hiện so sánh chính xác
        $controller = str_replace('\\', '/', strtolower($controller));
        $routeUri = str_replace('\\', '/', trim(parse_uri($routeUri), '/'));
        $uri = str_replace('\\', '/', $uri);
        // Kiểm tra nếu URI bắt đầu với routeUri (controller) và không có action cụ thể
        return strpos($uri, $routeUri) === 0 && strpos($uri, $controller) !== false;
    } */
    private function isControllerRoute($routeUri, $uri, $controller) {
        $controller = str_replace('\\', '/', strtolower($controller));
        $routeUri = str_replace('\\', '/', trim(parse_uri($routeUri), '/'));
        $uri = str_replace('\\', '/', $uri);
        // Kiểm tra nếu URI bắt đầu với routeUri (controller) và không có action cụ thể
        return strpos($uri, $routeUri) === 0 && strpos($uri, $controller) !== false;
    }

    /**
     * Lấy controller và action từ chuỗi controller::action
     */
    // private function getControllerAction($controllerString, $params) {
    //     list($controller, $action) = explode('::', $controllerString);
    //     return ["App\\Controllers\\{$controller}", $action, $params];
    // }
    private function getControllerAction($controllerString, $params) {
        list($controller, $action) = explode('::', $controllerString);

        // Nếu action chứa $1, $2... thì thay thế nó bằng giá trị trong $params
        if (strpos($action, '$') !== false) {
            $actionParts = explode(':', $action);
            $actionName = array_shift($actionParts); // Lấy tên action ban đầu

            // Nếu $1 xuất hiện trong actionName, nó đại diện cho tên action
            if (strpos($actionName, '$1') !== false && isset($params[0])) {
                $actionName = str_replace('$1', $params[0], $actionName);
                array_shift($params); // Loại bỏ giá trị đã được sử dụng cho action khỏi $params
            }
            // Thay thế các $2, $3,... bằng giá trị tương ứng trong $params còn lại
            foreach ($actionParts as $index => $part) {
                if (isset($params[$index])) {
                    $actionName = str_replace('$' . ($index + 2), $params[$index], $actionName);
                }
            }
            $action = $actionName;
        } else {
            // Trường hợp action không chứa tham số đại diện, sử dụng trực tiếp
            $action = strtolower($action);
        }
        return ["App\\Controllers\\{$controller}", $action, $params];
    }

    /**
     * Chuyển route thành regex để khớp với URI
     */
    private function convertToRegex($routeUri) {
        // Thay thế các mẫu đặc biệt giống như CodeIgniter
        $routeUri = str_replace('(:any)', '(.+)', $routeUri);
        $routeUri = str_replace('(:segment)', '([^/]+)', $routeUri);
        $routeUri = str_replace('(:num)', '(\d+)', $routeUri);
        $routeUri = str_replace('(:alpha)', '([a-zA-Z]+)', $routeUri);
        $routeUri = str_replace('(:alphadash)', '([a-zA-Z\-]+)', $routeUri); // Khớp chữ cái và dấu gạch ngang (-)
        $routeUri = str_replace('(:alphanum)', '([a-zA-Z0-9]+)', $routeUri);
        $routeUri = str_replace('(:alphanumdash)', '([a-zA-Z0-9\-]+)', $routeUri); // Khớp chữ cái, số và dấu gạch ngang (-)
    
        // Hỗ trợ cho các biểu thức chính quy tùy chỉnh
        $routeUri = preg_replace('#\(([a-zA-Z0-9_\-\.\[\]\+\*]+)\)#', '($1)', $routeUri);
    
        // Đưa route vào dạng biểu thức chính quy hoàn chỉnh
        return "#^" . $routeUri . "$#";
    }    

    /**
     * Tự động route từ URI thành Controller và Function
     * URI dạng /TenController/TenFunction/params...
     */
    private function autoRoute($uri) {
        $segments = explode('/', trim($uri, '/'));

        $controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
        $action = isset($segments[1]) ? $segments[1] : 'index';
        $params = array_slice($segments, 2);

        $controllerClass = "App\\Controllers\\{$controller}";
        if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
            return [
                'controller' => $controllerClass,
                'action' => $action,
                'params' => $params,
                'middleware' => [] // Auto route không có middleware
            ];
        }

        return false; // Nếu không tìm thấy controller/action
    }
}
