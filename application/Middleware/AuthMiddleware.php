<?php
namespace App\Middleware;

class AuthMiddleware {

    /**
     * Xử lý middleware
     * 
     * @param mixed $request Thông tin request
     * @param callable $next Middleware tiếp theo
     * @return mixed
     */
    public function handle($request, $next) {
        // Giả sử sử dụng session để kiểm tra người dùng đã đăng nhập
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang login
            //header('Location: /login');
            echo 'No Login';
            exit;
        }

        // Gọi middleware tiếp theo
        return $next($request);
    }
}
