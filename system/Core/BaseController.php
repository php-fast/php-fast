<?php
namespace System\Core;
use System\Libraries\Render;

// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}
class BaseController {

    /**
     * Dữ liệu sẽ được truyền vào view
     * @var array
     */
    protected $data = [];

    public function __construct() {
        // Các khởi tạo chung cho tất cả các controller
        // Ví dụ: load các helper, thư viện, kiểm tra phiên làm việc, v.v.
    }

    /**
     * Phương thức data: set hoặc get dữ liệu
     * - Nếu truyền 2 tham số: set dữ liệu
     * - Nếu truyền 1 tham số: get dữ liệu
     * 
     * @param string $key Tên của dữ liệu
     * @param mixed|null $value Giá trị của dữ liệu (nếu có)
     * @return mixed|null Trả về dữ liệu nếu chỉ truyền 1 tham số
     */
    public function data($key, $value = null) {
        if ($value !== null) {
            // Set dữ liệu nếu có 2 tham số
            $this->data[$key] = $value;
        } else {
            // Get dữ liệu nếu chỉ có 1 tham số
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }
    }

    /**
     * Gọi phương thức render từ thư viện Render để load view
     * 
     * @param string $layout Tên layout
     * @param string $view Tên view
     */
    protected function render($layout, $view, $isreturn = false) {
        if ($isreturn){
            return Render::render($layout, $view, $this->data);
        }else{
            echo Render::render($layout, $view, $this->data);
        }
    }

    /**
     * Trả về dữ liệu dưới dạng JSON
     */
    protected function json($data = [], $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    /**
     * Trả về JSON khi request thành công
     */
    protected function success($data = [], $message = 'Success') {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];
        $this->json($response);
    }

    /**
     * Trả về JSON khi có lỗi
     */
    protected function error($message = 'An error occurred', $errors = [], $statusCode = 400) {
        $response = [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ];
        $this->json($response, $statusCode);
    }
}