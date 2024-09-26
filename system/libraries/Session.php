<?php
namespace System\Libraries;
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Session {

    /**
     * Khởi tạo session nếu chưa bắt đầu
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set một giá trị vào session
     * 
     * @param string $key Tên của session
     * @param mixed $value Giá trị cần lưu
     */
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Lấy một giá trị từ session
     * 
     * @param string $key Tên của session
     * @return mixed|null Giá trị của session, hoặc null nếu không tồn tại
     */
    public static function get($key) {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    /**
     * Xóa một session cụ thể
     * 
     * @param string $key Tên của session cần xóa
     */
    public static function remove($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Hủy toàn bộ session
     */
    public static function destroy() {
        self::start();
        session_unset();
        session_destroy();
    }

    /**
     * Kiểm tra sự tồn tại của một session
     * 
     * @param string $key Tên session cần kiểm tra
     * @return bool True nếu session tồn tại, False nếu không
     */
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Tạo một thông báo tạm thời (flash data)
     * Dữ liệu này sẽ chỉ tồn tại trong request tiếp theo và bị xóa sau đó
     * 
     * @param string $key Tên của flash message
     * @param mixed $value Giá trị của flash message
     */
    public static function flash($key, $value) {
        self::start();
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * Lấy và xóa một thông báo tạm thời (flash data)
     * 
     * @param string $key Tên của flash message
     * @return mixed|null Giá trị của flash message hoặc null nếu không tồn tại
     */
    public static function flash_data($key) {
        self::start();
        $value = $_SESSION['flash'][$key] ?? null;
        if (isset($_SESSION['flash'][$key])) {
            unset($_SESSION['flash'][$key]);
        }
        return $value;
    }

    /**
     * Tái tạo session ID để tránh session fixation
     * Nên gọi sau khi người dùng đăng nhập hoặc thay đổi quyền truy cập
     */
    public static function regenerate() {
        self::start();
        session_regenerate_id(true);
    }

    /**
     * Kiểm tra và giới hạn thời gian tồn tại của session
     * Hủy session nếu đã hết thời gian
     * 
     * @param int $maxLifetime Thời gian tối đa tính bằng giây
     */
    public static function checkSessionTimeout($maxLifetime = 1800) {
        self::start();
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $maxLifetime)) {
            // Hủy session nếu quá thời gian cho phép
            self::destroy();
        }
        $_SESSION['last_activity'] = time(); // Cập nhật thời gian hoạt động cuối cùng
    }

    /**
     * Set và kiểm tra token CSRF trong session
     * 
     * @return string Token CSRF
     */
    public static function csrfToken() {
        self::start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Xác thực token CSRF từ session và dữ liệu form
     * 
     * @param string $token Token từ form
     * @return bool True nếu token hợp lệ, False nếu không
     */
    public static function verifyCsrfToken($token) {
        self::start();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}