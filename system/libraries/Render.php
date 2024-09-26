<?php
namespace System\Libraries;
use System\Core\AppException;
use Exception;

// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Render {
    /**
     * Tên của theme
     * @var string
     */
    private static $themeName;

    /**
     * Đường dẫn thư mục theme
     * @var string
     */
    private static $themePath;

     /**
     * Khởi tạo và load cấu hình theme một lần duy nhất
     */
    private static function init() {
        if (self::$themeName === null || self::$themePath === null) {
            // Lấy cấu hình theme từ file config
            $themeConfig = config('theme');
            // Lưu tên theme và đường dẫn theme
            self::$themeName = $themeConfig['theme_name'] ?? 'default';
            $themeRelativePath = $themeConfig['theme_path'] ?? 'application/views';
            self::$themePath = ROOT_PATH . '/' . $themeRelativePath . '/' . self::$themeName . '/';
            unset($themeConfig);
            unset($themeRelativePath);
        }
    }

    /**
     * Lấy tên của theme
     * 
     * @return string Tên theme
     */
    private static function _name() {
        self::init();
        return self::$themeName;
    }

    /**
     * Lấy đường dẫn của theme
     * 
     * @return string Đường dẫn thư mục theme
     */
    private static function _path_theme() {
        self::init();
        return self::$themePath;
    }

    /**
     * Lấy path của một component trong themes
     * 
     * @param string $component Tên component cần lấy path
     * @return string Đường dẫn đến component
     */
    public static function _path_component($component) {
        return self::_path_theme() . 'component/';
    }

    /**
     * Lấy path của thư mục theme theo controller
     * Ví dụ: controller Home thì thư mục theme là home/
     * 
     * @param string $controller Tên của controller
     * @return string Đường dẫn đến thư mục theme của controller
     */
    public static function _path_controller($controller) {
        return self::_path_theme() . strtolower($controller) . '/';
    }

    /**
     * Render toàn bộ layout và view với dữ liệu
     * 
     * @param string $layout Tên layout cần load (ví dụ: 'layout' hoặc 'layout2')
     * @param string $view Tên view cần load (ví dụ: 'home/home')
     * @param array $data Dữ liệu truyền vào view
     * @throws \Exception
     */
    public static function render($layout, $view, $data = []) {
        self::init(); // Đảm bảo cấu hình đã được load

        $layoutPath = self::_path_theme() . $layout . '.php';
        $viewPath = self::_path_theme() . $view . '.php';

        if (!file_exists($layoutPath)) {
            throw new AppException("Layout '{$layout}' not found at Path: '{$layoutPath}'.");
        }
        if (!file_exists($viewPath)) {
            throw new AppException("View '{$view}' not found at Path: '{$viewPath}'.");
        }

        // Thêm path của view vào data để truyền vào layout
        $data['view'] = $viewPath;

        // Truyền dữ liệu vào view
        extract($data);
        // Bắt đầu buffer để lưu output vào chuỗi
        ob_start();
        // Gọi layout chính và hiển thị nội dung
        require_once $layoutPath;
        return ob_get_clean();  // Trả về chuỗi
    }

    /**
     * Render một component cụ thể và trả về dưới dạng chuỗi
     * 
     * @param string $component Tên component cần render (ví dụ: 'header', 'footer')
     * @param array $data Dữ liệu truyền vào component
     * @return string Kết quả render component
     * @throws \Exception
     */
    public static function component($component, $data = []) {
        self::init(); // Đảm bảo cấu hình đã được load

        $componentPath = self::_path_theme() . $component . '.php';

        if (!file_exists($componentPath)) {
            throw new \Exception("Component '{$component}' không tồn tại tại đường dẫn '{$componentPath}'.");
        }

        // Truyền dữ liệu vào component
        extract($data);

        // Bắt đầu buffer để lưu output
        ob_start();
        require $componentPath;
        return ob_get_clean();
    }
}
