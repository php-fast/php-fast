
    <?php if (!empty($users)): ?>
        <table class="min-w-full bg-white border border-gray-300">
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach ($users as $user): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6"><?php echo $user['name']; ?></td>
                        <td class="py-3 px-6"><?php echo $user['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-gray-500">Không có người dùng nào.</p>
    <?php endif; ?>