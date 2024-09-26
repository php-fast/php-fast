<?php
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

/**
 * Hàm xss_clean
 * Lọc các đầu vào để tránh XSS (Cross-Site Scripting)
 * 
 * @param string $data Dữ liệu cần lọc
 * @return string Dữ liệu đã được làm sạch
 */
function xss_clean($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Hàm clean_input
 * Làm sạch dữ liệu đầu vào để tránh các lỗ hổng bảo mật như XSS
 * 
 * @param string $data Dữ liệu cần làm sạch
 * @return string Dữ liệu đã được làm sạch
 */
function clean_input($data) {
    return trim(stripslashes(htmlspecialchars($data, ENT_QUOTES, 'UTF-8')));
}

/**
 * Hàm uri_security
 * Làm sạch và bảo vệ URI tránh các cuộc tấn công XSS, SQL Injection
 * 
 * @param string $uri Dữ liệu URI cần làm sạch
 * @return string URI đã được làm sạch
 */
function uri_security($uri) {
    // Loại bỏ các ký tự không hợp lệ từ URI
    $uri = filter_var($uri, FILTER_SANITIZE_URL);

    // Áp dụng thêm các bước làm sạch XSS
    return xss_clean($uri);
}

