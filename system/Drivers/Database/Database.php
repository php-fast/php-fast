<?php

namespace System\Drivers\Database;

abstract class Database {

    protected $pdo;

    /**
     * Khởi tạo kết nối cơ sở dữ liệu
     * Mỗi driver sẽ tự triển khai phương thức kết nối này
     *
     * @param array $config Mảng chứa thông tin cấu hình kết nối
     */
    abstract public function __construct($config);

    /**
     * Thực thi truy vấn SQL tùy ý
     * 
     * @param string $query Câu lệnh SQL cần thực thi
     * @param array $params Mảng giá trị tương ứng với các tham số trong câu lệnh SQL
     * @return mixed Kết quả của truy vấn (sử dụng cho SELECT, INSERT, UPDATE, DELETE)
     */
    abstract public function query($query, $params = []);

    /**
     * Lấy ID của bản ghi vừa chèn
     * 
     * @return string ID của bản ghi vừa chèn
     */
    abstract public function lastInsertId();

    /**
     * Đếm số bản ghi trong bảng
     * 
     * @param string $table Tên bảng cần đếm số bản ghi
     * @param string $where Điều kiện WHERE để đếm số bản ghi (tùy chọn)
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE (tùy chọn)
     * @return int Số bản ghi trong bảng
     */
    abstract public function count($table, $where = '', $params = []);

    /**
     * Thực thi truy vấn SELECT lấy nhiều dòng
     * 
     * @param string $table Tên bảng cần truy vấn
     * @param string $where Điều kiện WHERE dưới dạng chuỗi (tùy chọn)
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE (tùy chọn)
     * @param string $orderBy Câu lệnh ORDER BY (tùy chọn)
     * @param int $limit Số lượng kết quả cần giới hạn (tùy chọn)
     * @param int $offset Vị trí bắt đầu lấy kết quả (tùy chọn)
     * @return array Mảng chứa kết quả truy vấn
     */
    abstract public function fetchAll($table, $where = '', $params = [], $orderBy = '', $limit = null, $offset = null);

    /**
     * Thực thi truy vấn SELECT lấy nhiều dòng với phân trang
     * 
     * @param string $table Tên bảng cần truy vấn
     * @param string $where Điều kiện WHERE dưới dạng chuỗi (tùy chọn)
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE (tùy chọn)
     * @param string $orderBy Câu lệnh ORDER BY (tùy chọn)
     * @param int $limit Số lượng kết quả cần giới hạn cho mỗi trang
     * @param int $offset Vị trí bắt đầu lấy kết quả (tùy chọn)
     * @return array Mảng chứa kết quả truy vấn và thông tin về trang tiếp theo
     */
    abstract public function fetchPagination($table, $where = '', $params = [], $orderBy = '', $limit = null, $offset = null);

    /**
     * Thực thi truy vấn SELECT lấy 1 dòng
     * 
     * @param string $table Tên bảng cần truy vấn
     * @param string $where Điều kiện WHERE dưới dạng chuỗi
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE
     * @return array|null Mảng chứa kết quả truy vấn hoặc null nếu không có kết quả
     */
    abstract public function fetchRow($table, $where = '', $params = []);

    /**
     * Thực thi truy vấn INSERT
     * 
     * @param string $table Tên bảng cần chèn dữ liệu
     * @param array $data Mảng dữ liệu cần chèn (dưới dạng 'cột' => 'giá trị')
     * @return bool Trả về true nếu chèn dữ liệu thành công, ngược lại là false
     */
    abstract public function insert($table, $data);

    /**
     * Thực thi truy vấn UPDATE
     * 
     * @param string $table Tên bảng cần cập nhật
     * @param array $data Mảng dữ liệu cần cập nhật (dưới dạng 'cột' => 'giá trị')
     * @param string $where Điều kiện WHERE để cập nhật dữ liệu
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE
     * @return bool Trả về true nếu cập nhật thành công, ngược lại là false
     */
    abstract public function update($table, $data, $where = '', $params = []);

    /**
     * Thực thi truy vấn DELETE
     * 
     * @param string $table Tên bảng cần xóa dữ liệu
     * @param string $where Điều kiện WHERE để xóa dữ liệu
     * @param array $params Mảng giá trị tương ứng với các tham số trong chuỗi WHERE
     * @return bool Trả về true nếu xóa thành công, ngược lại là false
     */
    abstract public function delete($table, $where = '', $params = []);
}
