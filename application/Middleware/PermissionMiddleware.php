<?php
namespace App\Middleware;

class PermissionMiddleware {

    /**
     * Xử lý middleware
     * 
     * @param mixed $request Thông tin request
     * @param callable $next Middleware tiếp theo
     * @return mixed
     */
    public function handle($request, $next) {
        // Giả sử kiểm tra quyền người dùng qua session
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            // Cho phép tiếp tục nếu người dùng là admin
            return $next($request);
        }

        // Nếu không phải admin, hiển thị thông báo lỗi
        http_response_code(403);
        echo "Bạn không có quyền truy cập vào trang này.";
        exit;
    }
}
