<h1><?= $title ?></h1>
<p><?= $message ?></p>
<form method="POST" action="/admin/edit">
    <!-- Form chỉnh sửa -->
    <input type="text" name="username" placeholder="Tên người dùng">
    <input type="submit" value="Cập nhật">
</form>
