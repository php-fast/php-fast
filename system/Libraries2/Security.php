<?php
namespace System\Libraries;
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Security {

    // Biến tĩnh lưu giữ app_id và app_secret
    protected static $app_id;
    protected static $app_secret;

    /**
     * Khởi tạo app_id và app_secret từ config
     */
    public static function init() {
        // Lấy app_id và app_secret từ config
        $security = config('security');
        if (empty($security['app_id']) || empty($security['app_secret'])) {
            throw new \Exception("App ID & Secret is not set in config.");
        }
        self::$app_id = $security['app_id'];
        self::$app_secret = $security['app_secret'];
    }

    /**
     * Mã hóa dữ liệu sử dụng AES-256-CBC với IV ngẫu nhiên
     * 
     * @param string $data Dữ liệu cần mã hóa
     * @return string Dữ liệu đã được mã hóa (IV + Data)
     */
    public static function encrypt($data) {
        if (is_null(self::$app_secret)) self::init(); // Đảm bảo app_secret đã được thiết lập
        
        $key = self::deriveKey(self::$app_secret); // Tạo khóa từ app_secret
        $iv = random_bytes(16); // IV ngẫu nhiên, 16 byte cho AES-256-CBC

        // Mã hóa dữ liệu
        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);

        // Trả về IV + dữ liệu mã hóa, lưu IV cùng với dữ liệu đã mã hóa
        return base64_encode($iv . $encryptedData);
    }

    /**
     * Giải mã dữ liệu đã được mã hóa sử dụng AES-256-CBC
     * 
     * @param string $encryptedData Dữ liệu đã mã hóa (IV + Data)
     * @return string|false Dữ liệu đã được giải mã, hoặc false nếu không thành công
     */
    public static function decrypt($encryptedData) {
        if (is_null(self::$app_secret)) self::init(); // Đảm bảo app_secret đã được thiết lập
        
        $key = self::deriveKey(self::$app_secret);
        $data = base64_decode($encryptedData);

        // Tách IV ra khỏi dữ liệu
        $iv = substr($data, 0, 16);
        $encryptedData = substr($data, 16);

        // Giải mã dữ liệu
        return openssl_decrypt($encryptedData, 'AES-256-CBC', $key, 0, $iv);
    }

    /**
     * Mã hóa mật khẩu sử dụng Bcrypt
     * 
     * @param string $password Mật khẩu cần mã hóa
     * @return string Mật khẩu đã được mã hóa
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Xác thực mật khẩu đã mã hóa
     * 
     * @param string $password Mật khẩu gốc
     * @param string $hashedPassword Mật khẩu đã mã hóa
     * @return bool True nếu mật khẩu khớp, False nếu không khớp
     */
    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Tạo một token ngẫu nhiên sử dụng cho CSRF hoặc các mục đích khác
     * 
     * @param int $length Độ dài token (mặc định 32)
     * @return string Token ngẫu nhiên
     */
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Tạo khóa mã hóa từ app_secret bằng cách sử dụng HMAC-SHA256
     * 
     * @param string $secret Giá trị bí mật
     * @return string Khóa mã hóa
     */
    private static function deriveKey($secret) {
        // Sử dụng HMAC-SHA256 để tạo khóa mạnh mẽ từ app_secret
        return hash_hmac('sha256', $secret, 'framework_secret_key', true); // true để lấy dạng binary
    }

    /**
     * Tạo chữ ký (signature) bảo vệ dữ liệu, dùng để đảm bảo dữ liệu không bị thay đổi
     * 
     * @param string $data Dữ liệu cần tạo chữ ký
     * @return string Chữ ký HMAC-SHA256
     */
    public static function createSignature($data) {
        if (is_null(self::$app_secret)) self::init(); // Đảm bảo app_secret đã được thiết lập

        return hash_hmac('sha256', $data, self::$app_secret);
    }

    /**
     * Kiểm tra chữ ký của dữ liệu có khớp với chữ ký đã tạo hay không
     * 
     * @param string $data Dữ liệu gốc
     * @param string $signature Chữ ký đã được tạo
     * @return bool True nếu chữ ký hợp lệ, False nếu không
     */
    public static function verifySignature($data, $signature) {
        $calculatedSignature = self::createSignature($data);
        return hash_equals($calculatedSignature, $signature); // Sử dụng hash_equals để chống tấn công timing attack
    }
}