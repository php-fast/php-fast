# PHP-Fast Framework

PHP-Fast là một framework MVC nhẹ và hiệu quả dành cho phát triển ứng dụng web bằng PHP. Với cấu trúc rõ ràng và dễ tùy chỉnh, PHP-Fast mang đến cho các lập trình viên một nền tảng mạnh mẽ để xây dựng các dự án từ nhỏ đến lớn. Framework này được thiết kế dựa trên mô hình MVC (Model-View-Controller), hỗ trợ các tính năng hiện đại như tạo Controller, Model, đồng bộ hóa cơ sở dữ liệu qua CLI, sử dụng Middleware, và quản lý bộ nhớ đệm (Cache) linh hoạt.

Framework hỗ trợ tất cả các chức năng cơ bản cần thiết để phát triển ứng dụng web, đồng thời vẫn để lại sự linh hoạt cho người dùng trong việc tuỳ biến các phần của ứng dụng theo yêu cầu riêng.

## Table of Contents

1. **Giới Thiệu**
    - Tổng quan
    - Tính năng
    - Yêu cầu hệ thống
2. **Bắt Đầu**
    - Cài đặt
    - Cấu trúc thư mục
    - Cấu hình cơ bản
3. **Chạy Ứng Dụng**
    - Chạy trên máy phát triển (Local Development Server)
    - Triển khai trên môi trường sản xuất (Production Deployment)
4. **Khái Niệm Cốt Lõi**
    - Mô hình MVC
    - Routing
    - Controllers
    - Models
    - Views
    - Middlewares
5. **Giao Diện Dòng Lệnh (CLI)**
    - Tổng quan
    - Các lệnh
        - `php init table <name>`
        - `php init controllers <name>`
        - `php init models <name>`
6. **Làm Việc với Controllers**
    - Tạo Controller
    - Tạo Controller qua CLI
    - Sử dụng Views trong Controllers
7. **Làm Việc với Models**
    - Tạo Model
    - Tạo Model qua CLI
    - Đồng bộ hóa Schema với Database
    - Thao tác CRUD cơ bản
8. **Routing**
    - Định nghĩa Routes
    - Truyền tham số trong Route
    - Tích hợp Middleware trong Routes
9. **Middlewares**
    - Tạo Middleware
    - Đăng ký Middleware trong Routes
10. **Helpers và Libraries**
    - Core Helpers
    - Security Helpers
    - Các thư viện tùy chỉnh (Logger, Session, v.v.)
11. **Views và Templating**
    - Tạo Views
    - Truyền dữ liệu vào Views
    - Sử dụng Components trong Views
12. **Xử Lý Lỗi và Logging**
    - Trang lỗi tùy chỉnh
    - Cơ chế ghi log
13. **Bảo Mật**
    - Làm sạch dữ liệu đầu vào (Input Sanitization)
    - Bảo vệ CSRF
    - Mã hóa dữ liệu (Encryption)
14. **Tính Năng Nâng Cao**
    - Quản lý Cache
    - Giám sát và hiệu năng
    - Lệnh tùy chỉnh
15. **Triển Khai Ứng Dụng**
    - Cài đặt trong môi trường sản xuất
    - Cấu hình `.htaccess` và thư mục `public`
16. **Đóng Góp**
    - Hướng dẫn đóng góp
    - Tiêu chuẩn mã nguồn
    - Báo cáo lỗi và gửi pull request
17. **Giấy Phép**
    - Thông tin giấy phép sử dụng

