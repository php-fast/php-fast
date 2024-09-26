<?php
namespace System\Libraries;
// Kiểm tra nếu không có ROOT_PATH, ngăn chặn truy cập
if (!defined('ROOT_PATH')) {
    exit('No direct access allowed.');
}

class Monitor {

    /**
     * Kết thúc đo lường và trả về kết quả đo lường toàn bộ request từ khi framework khởi động
     * @return array Kết quả đo lường gồm thời gian, bộ nhớ, CPU sử dụng
     */
    public static function endFramework() {
        // Thời gian kết thúc
        $endTime = microtime(true);
        // Bộ nhớ kết thúc
        $endMemory = memory_get_usage();

        // Tính toán thời gian thực thi từ lúc khởi tạo framework
        $executionTime = $endTime - START_TIME;

        // Tính toán bộ nhớ sử dụng từ lúc khởi tạo framework
        $memoryUsed = $endMemory - START_MEMORY;

        // Kiểm tra xem hàm sys_getloadavg có tồn tại hay không (nếu không sẽ bỏ qua)
        if (function_exists('sys_getloadavg')) {
            $cpuUsage = sys_getloadavg()[0]; // Lấy CPU load trung bình trong 1 phút
        } else {
            $cpuUsage = 'Không khả dụng trên hệ thống này';
        }

        return [
            'execution_time' => $executionTime, // Thời gian thực thi
            'memory_used'    => $memoryUsed,    // Bộ nhớ sử dụng
            'cpu_usage'      => $cpuUsage       // CPU load hoặc thông báo
        ];
    }

    /**
     * Định dạng kích thước bộ nhớ theo đơn vị (Bytes, KB, MB, GB)
     * @param int $size Kích thước bộ nhớ
     * @return string Kích thước bộ nhớ đã được định dạng
     */
    public static function formatMemorySize($size) {
        if ($size < 1024) {
            return $size . ' Bytes';
        } elseif ($size < 1048576) {
            return round($size / 1024, 2) . ' KB';
        } elseif ($size < 1073741824) {
            return round($size / 1048576, 2) . ' MB';
        } else {
            return round($size / 1073741824, 2) . ' GB';
        }
    }
}
