<?php
namespace System\Drivers\Cache;

abstract class Cache {
    
    protected $config;

    /**
     * Khởi tạo Cache
     *
     * @param array $config Cấu hình Cache
     */
    public function __construct($config) {
        $this->config = $config;
        $this->connect();
    }

    /**
     * Phương thức trừu tượng kết nối đến Cache driver (Redis, File,...)
     */
    abstract protected function connect();

    /**
     * Lưu một giá trị vào cache
     *
     * @param string $key Khóa của giá trị
     * @param mixed $value Giá trị cần lưu
     * @param int $ttl Thời gian tồn tại (tùy chọn)
     * @return bool Trả về true nếu lưu thành công
     */
    abstract public function set($key, $value, $ttl = 3600);

    /**
     * Lấy giá trị từ cache theo khóa
     *
     * @param string $key Khóa của giá trị
     * @return mixed Giá trị lưu trữ hoặc null nếu không có
     */
    abstract public function get($key);

    /**
     * Xóa một giá trị khỏi cache
     *
     * @param string $key Khóa của giá trị
     * @return bool Trả về true nếu xóa thành công
     */
    abstract public function delete($key);

    /**
     * Kiểm tra một giá trị có tồn tại trong cache hay không
     *
     * @param string $key Khóa của giá trị
     * @return bool Trả về true nếu tồn tại
     */
    abstract public function has($key);

    /**
     * Xóa tất cả giá trị trong cache
     *
     * @return bool Trả về true nếu xóa thành công
     */
    abstract public function clear();
}
