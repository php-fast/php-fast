<?php
namespace App\Controllers;

use System\Core\BaseController;
use System\Libraries\Render;
use App\Models\UsersModel;
//use System\Drivers\Cache\RedisCache;


class HomeController extends BaseController {

    protected $usersModel;
    //protected $cache;

    public function __construct() {
        //parent::__construct();
        //$config = config('cache'); // Lấy cấu hình cache từ file config.php
        //$this->cache = new RedisCache($config);
        $this->usersModel = new UsersModel(); // Khởi tạo model Users
    }

    /**
     * Trang chủ, hiển thị danh sách người dùng
     */
    public function index() {
        /*
        $cacheKey = 'home_page';
        // Kiểm tra cache trước
        $cacheContent = $this->cache->get($cacheKey);
        if ($cacheContent) {
            echo $cacheContent;
            echo 'da load cache <br />';
            //return;
        }else{*/
            // Lấy danh sách người dùng
            $users = $this->usersModel->getUsersPaging(10, 1); // Lấy 10 người dùng, trang 1

            // Set dữ liệu cho view
            $this->data('title', 'Đây Là Trang Chủ');
            $this->data('users', $users['data']); // Truyền danh sách người dùng vào view

            // Render từng phần và lưu vào biến (có thể cache)
            $header = Render::component('component/header', ['title' => $this->data('title')]);
            $footer = Render::component('component/footer');

            // Gọi layout chính và truyền dữ liệu cùng với các phần render
            $this->data('header', $header);
            $this->data('footer', $footer);

            // Render layout và view
            $content = $this->render('themes', 'home/home');
            // Lưu chuỗi render vào cache
            //$this->cache->set($cacheKey, $content, 600); // Lưu cache 10 phút (600 giây)
            // Hiển thị kết quả
            echo $content;
        //}
            
    }

    // Thêm người dùng mới
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'age' => $_POST['age'],
            ];
            $this->usersModel->addUser($data);

            header('Location: /');
            exit;
        }

        $this->data('title', 'Thêm người dùng mới');
        $this->render('themes', 'home/add_user');
    }

    // Cập nhật thông tin người dùng
    public function editUser($id) {
        $user = $this->usersModel->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'age' => $_POST['age'],
            ];
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $this->usersModel->updateUser($id, $data);

            header('Location: /');
            exit;
        }

        $this->data('title', 'Chỉnh sửa người dùng');
        $this->data('user', $user);
        $this->render('themes', 'home/edit_user');
    }

    // Xóa người dùng
    public function deleteUser($id) {
        $this->usersModel->deleteUser($id);

        header('Location: /');
        exit;
    }

    // Xem chi tiết người dùng
    public function viewUser($id) {
        $user = $this->usersModel->getUserById($id);

        if (!$user) {
            die('Người dùng không tồn tại');
        }

        $this->data('title', 'Thông tin người dùng');
        $this->data('user', $user);
        $this->render('themes', 'home/view_user');
    }
}
