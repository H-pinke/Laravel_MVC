<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>laravel blade 模板视图</h3>
用户ID:<?php echo e($data['id']); ?> <br/>
用户昵称:<?php echo e($data['name']); ?> <br/>
用户邮箱:<?php echo e($data['email']); ?> <br/>
</body>
</html><?php /**PATH /www/laravel_basics/resources/views/welcome.blade.php ENDPATH**/ ?>