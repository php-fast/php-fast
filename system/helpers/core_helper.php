<?php

// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

/**
 * Hàm load_helpers
 * Load danh sách các helpers được chỉ định
 * 
 * @param array $helpers Danh sách các helper cần load
 */
function load_helpers(array $helpers = []) {
    foreach ($helpers as $helper) {
        $helperPath = ROOT_PATH . '/system/helpers/' . $helper . '_helper.php';
        if (file_exists($helperPath)) {
            require_once $helperPath;
        } else {
            throw new Exception("Helper file not found: " . $helperPath);
        }
    }
}

/**
 * Hàm version_php
 * Lấy ra phiên bản PHP hiện tại
 * 
 * @return string Phiên bản PHP hiện tại
 */
function version_php() {
    return PHP_VERSION;
}

/**
 * Hàm dir_writable
 * Kiểm tra đường dẫn có phải là thư mục và có quyền ghi hay không
 * 
 * @param string $path Đường dẫn cần kiểm tra
 * @return bool True nếu là thư mục và có quyền ghi, ngược lại False
 */
function path_writable($path) {
    return is_dir($path) && is_writable($path);
}

/**
 * Hàm not_empty
 * Kiểm tra xem một giá trị có rỗng hay không. Nếu là mảng thì đếm số phần tử.
 * 
 * @param mixed $value Giá trị cần kiểm tra
 * @return bool True nếu không rỗng, False nếu rỗng
 */
function not_empty($value) {
    if (is_array($value)) {
        return count($value) > 0;
    }
    return !empty($value);
}

/**
 * Hàm server_info
 * Trả về thông tin về máy chủ hiện tại (bao gồm PHP version, server software, etc.)
 * 
 * @return array Mảng chứa thông tin về máy chủ
 */
function server_info() {
    return [
        'php_version' => version_php(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
        'server_name' => $_SERVER['SERVER_NAME'] ?? 'Unknown',
        'server_protocol' => $_SERVER['SERVER_PROTOCOL'] ?? 'Unknown',
    ];
}

/**
 * Hàm random_string
 * Tạo ra một chuỗi ngẫu nhiên với độ dài mong muốn
 * 
 * @param int $length Độ dài của chuỗi ngẫu nhiên cần tạo
 * @return string Chuỗi ngẫu nhiên đã được tạo
 */
function random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * Hàm json_response
 * Gửi phản hồi JSON tới client
 * 
 * @param mixed $data Dữ liệu cần trả về dưới dạng JSON
 * @param int $status_code Mã trạng thái HTTP
 */
function json_response($data, $status_code = 200) {
    header('Content-Type: application/json');
    http_response_code($status_code);
    echo json_encode($data);
    exit();
}

/**
 * Hàm lấy cấu hình từ file config.php
 * 
 * @param string $key Tên của cấu hình cần lấy
 * @param mixed $default Giá trị mặc định nếu không tìm thấy cấu hình
 * @return mixed Giá trị của cấu hình hoặc giá trị mặc định
 */
function config($key) {
    static $config;

    if (!$config) {
        $config = require ROOT_PATH . '/application/config/config.php';
    }
    return $config[$key] ?? null;
}

/**
 * Hàm env
 * Lấy giá trị biến môi trường từ bộ nhớ cache hoặc đọc từ file .env (nếu chưa tồn tại trong cache)
 * 
 * @param string $key Tên biến môi trường cần lấy
 * @param mixed $default Giá trị mặc định nếu biến không tồn tại
 * @return mixed Giá trị của biến môi trường hoặc giá trị mặc định
 */
function env($key, $default = null) {
    // Sử dụng một mảng tĩnh để lưu trữ các giá trị đã được load
    static $env_cache = [];

    // Nếu giá trị đã tồn tại trong cache, trả về giá trị từ cache
    if (isset($env_cache[$key])) {
        return $env_cache[$key];
    }

    // Lấy giá trị từ biến môi trường
    $value = getenv($key);

    // Nếu không tìm thấy biến môi trường, sử dụng giá trị mặc định
    if ($value === false) {
        $env_cache[$key] = $default;
        return $default;
    }

    // Loại bỏ các ký tự không an toàn và lưu vào cache
    $value = trim($value);
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

    // Xử lý các giá trị đặc biệt: true, false, null
    switch (strtolower($value)) {
        case 'true':
            $env_cache[$key] = true;
            break;
        case 'false':
            $env_cache[$key] = false;
            break;
        case 'null':
            $env_cache[$key] = null;
            break;
        default:
            $env_cache[$key] = $value;
    }

    return $env_cache[$key];
}