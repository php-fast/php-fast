<?php
namespace App\Controllers;

use System\Core\BaseController;

class AdminController extends BaseController {

    public function index() {
        // Chỉ admin mới có thể vào được phần này
        $this->data('title', 'Trang quản trị');
        $this->data('message', 'Chào mừng bạn đến với trang quản trị của chúng tôi!');
        
        // Render view cho trang quản trị
        $this->render('themes', 'admin/dashboard');
    }

    public function index2() {
        // Chỉ admin mới có thể vào được phần này
        $this->data('title', 'Trang quản trị');
        $this->data('message', 'Chào mừng bạn đến với trang quản trị của chúng tôi!');
        
        // Render view cho trang quản trị
        $this->render('themes', 'admin/dashboard');
    }


    public function edit() {
        // Trang chỉnh sửa admin
        $this->data('title', 'Chỉnh sửa thông tin');
        $this->data('message', 'Chỉnh sửa thông tin của bạn.');

        // Render view cho trang chỉnh sửa
        $this->render('themes', 'admin/edit');
    }

    public function delete() {
        // Xử lý xóa người dùng
        $this->data('message', 'Người dùng đã bị xóa thành công.');

        // Render trang xóa
        $this->render('themes', 'admin/delete');
    }
}
