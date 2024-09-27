<?php
namespace System\Core;
use Exception;
use System\Libraries\Logger;

// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class AppException extends Exception {

    protected $statusCode;

    public function __construct($message, $code = 0, Exception $previous = null, $statusCode = 500) {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Xử lý ngoại lệ, ghi log và hiển thị thông tin lỗi.
     */
    public function handle() {
        // Ghi log lỗi
        Logger::error($this->getMessage(), $this->getFile(), $this->getLine());
        // Hiển thị thông tin ngoại lệ cho người dùng
        if ($this->statusCode == 404) {
            $this->render404();
        } else {
            // Hiển thị thông tin ngoại lệ chung cho các lỗi khác
            $this->renderError();
        }
    }

    /**
     * Hiển thị trang lỗi 404 từ view.
     */
    private function render404() {
        http_response_code($this->statusCode);
        
        $htmlerr = '';
        // Nếu chế độ debug bật, hiển thị thông tin chi tiết
        if (!empty(config('app')['debug'])) {
            $htmlerr .= "<h1>Error {$this->statusCode}</h1>";
            $htmlerr .= "<p>{$this->getMessage()}</p>";
            $htmlerr .= "<p>File: {$this->getFile()}</p>";
            $htmlerr .= "<p>Line: {$this->getLine()}</p>";
            $htmlerr .= "<p>Trace: <pre>{$this->getTraceAsString()}</pre></p>";
        } else {
            // Hiển thị thông báo chung nếu chế độ debug tắt
            $htmlerr .= "<h1>Oops! Something went wrong.</h1>";
            $htmlerr .= "<p>We're experiencing technical difficulties. Please try again later.</p>";
        }
        echo \System\Libraries\Render::render('themes', '404', ['errors'=>$htmlerr]);
        unset($htmlerr);
        exit(); // Ngừng thực thi tiếp
    }

    /**
     * Hiển thị thông tin ngoại lệ dưới dạng HTML cho người dùng.
     */
    private function renderError() {
        http_response_code($this->statusCode);
        // Nếu chế độ debug bật, hiển thị thông tin chi tiết
        if (!empty(config('app')['debug'])) {
            echo "<h1>Error {$this->statusCode}</h1>";
            echo "<p>{$this->getMessage()}</p>";
            echo "<p>File: {$this->getFile()}</p>";
            echo "<p>Line: {$this->getLine()}</p>";
            echo "<p>Trace: <pre>{$this->getTraceAsString()}</pre></p>";
        } else {
            // Hiển thị thông báo chung nếu chế độ debug tắt
            echo "<h1>Oops! Something went wrong.</h1>";
            echo "<p>We're experiencing technical difficulties. Please try again later.</p>";
        }
        exit(); // Ngừng thực thi tiếp
    }
}
