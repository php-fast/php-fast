<?php
namespace System\Core;
use System\Libraries\Logger;
use Exception;

// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}
// Load Core_helper.php để có thể sử dụng hàm load_helpers
require_once ROOT_PATH . '/system/Helpers/Core_helper.php';

class Bootstrap {

    protected $routes;

    public function __construct() {
        load_helpers(['uri', 'security']); // Load các helper như Uri_helper, Security_helper
        $appConfig = config('app');
        if (!empty($appConfig['app_timezone'])) {
            date_default_timezone_set($appConfig['app_timezone']);
        }
        $this->routes = new Router(); // Tạo instance cho Router
        $this->loadRoutes();          // Load các route
    }

    /**
     * Khởi động framework
     */
    public function run() {
        try {
            // Làm sạch và xử lý URI
            $uri = uri_security(request_uri());
            if (!isset($_SERVER['REQUEST_METHOD'])) $_SERVER['REQUEST_METHOD'] = 'GET';
            $method = $_SERVER['REQUEST_METHOD'];
            // Tìm và xử lý route khớp với URI
            $this->dispatch($uri, $method);
        } catch (AppException $e) {
            $e->handle();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine());
            http_response_code(500);
            echo "An unknown error has occurred. Lets check file logger.log";
        }
    }

    /**
     * Load các routes từ file routes/web.php và routes/api.php
     */
    private function loadRoutes() {
        global $routes;
        // Khởi tạo đối tượng Router
        $routes = $this->routes;
        // Load routes cho web
        require_once ROOT_PATH . '/application/Routes/Web.php';
        // Load routes cho API (nếu có)
        if (file_exists(ROOT_PATH . '/application/Routes/Api.php')) {
            require_once ROOT_PATH . '/application/Routes/Api.php';
        }
    }    

    /**
     * Điều hướng URI đến controller và action tương ứng
     */
    private function dispatch($uri, $method) {
        $route = $this->routes->match($uri, $method);
        
        if (!$route) {
            throw new AppException("404 - Router: /{$uri} ({$method}) not found!", 404, null, 404);
        }

        //xu ly Middleware truoc khi goi den Controller.
        $middleware = new Middleware();
        if (!empty($route['middleware'])) {
            // Thêm các middleware vào danh sách nếu có tồn tại Middleware
            foreach ($route['middleware'] as $mw) {
                $middleware->add($mw);
            }
        }

        // Thực thi middleware trước khi gọi controller
        $middleware->handle($uri, function () use ($route) {
            // Lấy thông tin controller và phương thức từ route đã khớp
            $controllerClass = $route['controller'];
            $action = $route['action'];
            $params = $route['params'];
            
            // Kiểm tra controller có tồn tại không
            if (!class_exists($controllerClass)) {
                throw new AppException("Controller {$controllerClass} not found.", 404, null, 404);
            }
            // Khởi tạo đối tượng controller
            $controller = new $controllerClass();

            // Kiểm tra action có tồn tại không
            if (!method_exists($controller, $action)) {
                throw new AppException("Action {$action} not found in {$controllerClass} Controller.", 404, null, 404);
            }

            // Gọi controller và action với các tham số
            call_user_func_array([$controller, $action], $params);
        });
    }
}
