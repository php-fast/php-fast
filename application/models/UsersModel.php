<?php
namespace App\Models;
use System\Core\BaseModel;

class UsersModel extends BaseModel {

    protected $table = 'users';

    // Các cột được phép thêm hoặc sửa
    protected $fillable = ['name', 'email', 'password', 'age'];

    // Các cột không được phép sửa
    protected $guarded = ['id', 'created_at'];

    /**
     * Định nghĩa cấu trúc bảng với schema builder
     * 
     * @return array Cấu trúc bảng
     */
    public function _schema() {
        return [
            'id' => [
                'type' => 'int unsigned',
                'auto_increment' => true,
                'key' => 'primary',
                'null' => false
            ],
            'name' => [
                'type' => 'varchar(150)',
                'key' => 'unique',
                'null' => false,
                'default' => ''
            ],
            'email' => [
                'type' => 'varchar(150)',
                'key'   =>  'unique',
                'null' => false,
                'default' => ''
            ],
            'password' => [
                'type' => 'varchar(100)',
                'null' => true,
                'default' => '1234567890123456789012345678932'
            ],
            'age' => [
                'type' => 'int',
                'key'   =>  'unique',
                'unsigned' => true,
                'null' => true,
                'default' => '18'
            ],
            'created_at' => [
                'type' => 'timestamp',
                'null' => true,
                'default' => '2020-01-01 01:01:01',
                'on_update' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'timestamp',
                'null' => true,
                'default' => '2020-01-01 01:01:01',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ];
    }

    /**
     * Lấy tất cả người dùng
     * 
     * @param string|null $where Điều kiện truy vấn (tùy chọn)
     * @param array $params Mảng giá trị tương ứng với chuỗi điều kiện
     * @param string|null $orderBy Sắp xếp theo cột (tùy chọn)
     * @param int|null $limit Giới hạn số lượng kết quả (tùy chọn)
     * @param int|null $offset Bắt đầu từ bản ghi thứ mấy (tùy chọn)
     * @return array Danh sách người dùng
     */
    public function getUsers($where = '', $params = [], $orderBy = 'id DESC', $limit = null, $offset = null) {
        return $this->list($this->table, $where, $params, $orderBy, $limit, $offset);
    }

    /**
     * Lấy danh sách người dùng với phân trang
     * 
     * @param int $page Trang hiện tại
     * @param int $limit Số lượng kết quả trên mỗi trang
     * @return array Danh sách người dùng và thông tin phân trang
     */
    public function getUsersPaging($limit = 10, $page = 1) {
        return $this->listpaging($this->table, 'age > ?', [18], 'age DESC', $limit, ($page - 1) * $limit);
    }

    /**
     * Lấy thông tin người dùng theo ID
     * 
     * @param int $id ID người dùng
     * @return array|false Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserById($id) {
        return $this->row($this->table, 'id = ?', [$id]);
    }

    /**
     * Thêm người dùng mới
     * 
     * @param array $data Dữ liệu người dùng cần thêm
     * @return bool Thành công hoặc thất bại
     */
    public function addUser($data) {
        $data = $this->fill($data); // Lọc dữ liệu được phép thêm
        return $this->add($this->table, $data);
    }

    /**
     * Cập nhật thông tin người dùng
     * 
     * @param int $id ID người dùng cần cập nhật
     * @param array $data Dữ liệu cần cập nhật
     * @return int Số dòng bị ảnh hưởng
     */
    public function updateUser($id, $data) {
        $data = $this->fill($data); // Lọc dữ liệu được phép sửa
        return $this->set($this->table, $data, 'id = ?', [$id]);
    }

    /**
     * Xóa người dùng
     * 
     * @param int $id ID người dùng cần xóa
     * @return int Số dòng bị ảnh hưởng
     */
    public function deleteUser($id) {
        return $this->del($this->table, 'id = ?', [$id]);
    }
}
