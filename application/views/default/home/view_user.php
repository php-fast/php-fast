<section class="bg-white p-6 rounded shadow-md">
    <h2 class="text-3xl font-bold mb-4">Thông tin người dùng</h2>

    <p><strong>Tên:</strong> <?php echo $user['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
    <p><strong>Tuổi:</strong> <?php echo $user['age']; ?></p>
    <p><strong>Ngày tạo:</strong> <?php echo $user['created_at']; ?></p>
    <p><strong>Cập nhật lần cuối:</strong> <?php echo $user['updated_at']; ?></p>

    <a href="./" class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Quay lại</a>
</section>
