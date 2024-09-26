<?php
namespace System\Libraries;
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Logger {

    /**
     * Ghi log dạng thông tin.
     */
    public static function info($message, $file = null, $line = null) {
        self::log('INFO', $message, $file, $line);
    }

    /**
     * Ghi log dạng cảnh báo.
     */
    public static function warning($message, $file = null, $line = null) {
        self::log('WARNING', $message, $file, $line);
    }

    /**
     * Ghi log dạng lỗi.
     */
    public static function error($message, $file = null, $line = null) {
        self::log('ERROR', $message, $file, $line);
    }

    /**
     * Hàm ghi log chính.
     */
    protected static function log($level, $message, $file = null, $line = null) {
        $logFile = WRITE_PATH . '/logs/logger.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$level}: {$message}";

        if ($file && $line) {
            $logMessage .= " in {$file} on line {$line}";
        }

        $logMessage .= PHP_EOL;

        // Kiểm tra và tạo thư mục log nếu chưa tồn tại
        if (!file_exists(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        // Ghi log vào file
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
