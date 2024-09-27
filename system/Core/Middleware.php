<?php
namespace System\Core;

class Middleware {

    protected $Middleware = [];
    protected $current = 0;

    /**
     * Thêm middleware vào danh sách
     *
     * @param callable|string $middleware Tên middleware hoặc callback
     */
    public function add($middleware) {
        $this->Middleware[] = $middleware;
    }

    /**
     * Thực thi middleware
     *
     * @param mixed $request Request hiện tại
     * @param callable $next Callback khi middleware hoàn tất
     * @return mixed
     */
    public function handle($request, $next) {
        // Nếu còn middleware chưa được thực thi
        if ($this->current < count($this->Middleware)) {
            $middleware = $this->Middleware[$this->current];
            $this->current++;

            // Nếu middleware là callback - Thực thi middleware hiện tại
            if (is_callable($middleware)) {
                return $middleware($request, function ($request) use ($next) {
                    return $this->handle($request, $next); // Gọi middleware tiếp theo
                });
            }

            // Nếu middleware là chuỗi class, khởi tạo và gọi handle
            if (is_string($middleware) && class_exists($middleware)) {
                $middlewareInstance = new $middleware();
                return $middlewareInstance->handle($request, function ($request) use ($next) {
                    return $this->handle($request, $next);
                });
            }
        }

        // Không còn middleware nào, chuyển đến xử lý tiếp theo (controller)
        return $next($request);
    }
}