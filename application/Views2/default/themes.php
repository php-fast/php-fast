<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Website'; ?></title>
</head>
<body>

    <?php if (isset($header)) echo $header; ?>

    <main class="container mx-auto my-8">
        <?php if (isset($view)) require $view; ?>
    </main>

    <?php if (isset($footer)) echo $footer; ?>

</body>
</html>