<section class="bg-white p-6 rounded shadow-md">
    <h2 class="text-3xl font-bold mb-4">Chỉnh sửa người dùng</h2>

    <form action="../editUser/<?php echo $user['id']; ?>" method="POST" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu (để trống nếu không muốn thay đổi)</label>
            <input type="password" id="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
        </div>
        <div>
            <label for="age" class="block text-sm font-medium text-gray-700">Tuổi</label>
            <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật người dùng</button>
    </form>
</section>
