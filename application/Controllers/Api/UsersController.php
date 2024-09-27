<?php
namespace App\Controllers\Api;

use System\Core\BaseController;
use App\Models\UsersModel;
use System\Core\AppException;

class UsersController extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        parent::__construct();
        $this->usersModel = new UsersModel();
    }

    // Lấy danh sách tất cả người dùng
    public function index()
    {
        try {
            $users = $this->usersModel->getUsers();
            $this->success($users, 'Users retrieved successfully.');
        } catch (AppException $e) {
            $this->error($e->getMessage(), [], 500);
        }
    }

    // Lấy thông tin người dùng theo ID
    public function show($id = '')
    {
        try {
            $user = $this->usersModel->getUserById($id);
            if ($user) {
                $this->success($user, 'User retrieved successfully.');
            } else {
                $this->error('User not found', [], 404);
            }
        } catch (AppException $e) {
            $this->error($e->getMessage(), [], 500);
        }
    }

    // Thêm người dùng mới
    public function store()
    {
        try {
            $data = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'password' => $_POST['password'] ?? null,
                'age' => $_POST['age'] ?? null,
            ];

            $userId = $this->usersModel->addUser($data);
            if ($userId) {
                $this->success(['user_id' => $userId], 'User created successfully.');
            } else {
                $this->error('Failed to create user');
            }
        } catch (AppException $e) {
            $this->error($e->getMessage(), [], 500);
        }
    }

    // Cập nhật thông tin người dùng
    public function update($id)
    {
        try {
            $data = [
                'name' => $_POST['name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'password' => $_POST['password'] ?? null,
                'age' => $_POST['age'] ?? null,
            ];

            $result = $this->usersModel->updateUser($id, $data);
            if ($result) {
                $this->success([], 'User updated successfully.');
            } else {
                $this->error('Failed to update user');
            }
        } catch (AppException $e) {
            $this->error($e->getMessage(), [], 500);
        }
    }

    // Xóa người dùng
    public function delete($id)
    {
        try {
            $result = $this->usersModel->deleteUser($id);
            if ($result) {
                $this->success([], 'User deleted successfully.');
            } else {
                $this->error('Failed to delete user');
            }
        } catch (AppException $e) {
            $this->error($e->getMessage(), [], 500);
        }
    }
}
