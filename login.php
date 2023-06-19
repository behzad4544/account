<?php
require "./newffff/Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
global $db;
$token = false;
if (isset($_SESSION['username'])) {
    header("location:index.php");
}
$errors = [];
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && !(empty($_POST['username']))) {
        $username = $_POST['username'];
    } else {
        $errors[] = 'لطفا نام کاربری خود را وارد کنید';
    }
    if (isset($_POST['password']) && !(empty($_POST['password']))) {
        $password = $_POST['password'];
        $sql = "select * from users where user_name=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user === false) {
            $errors[] = 'نام کاربری یا پسورد شما در سامانه وجود ندارد';
        } else {
            if (password_verify($password, $user->user_password)) {
                $token = true;
                $_SESSION['username'] = $user->user_name;
                $_SESSION['permition'] = $user->permition_id;
                if (isset($_POST['check']) && $_POST['check'] == 1) {
                    setcookie('username', $user->user_name, time() + 7200);
                    setcookie('password', $password, time() + 7200);
                } else {
                    setcookie('username', $user->user_name, time() - 7200);
                    setcookie('password', $password, time() - 7200);
                }
            } else {
                $errors[] = 'نام کاربری یا پسورد شما در سامانه وجود ندارد';
            }
        }
    } else {
        $errors[] = 'لطفا رمز خود را وارد کنید';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <link rel='stylesheet' href='./newffff/CSS/sweet-alert.css'>

    <!-- CSS File -->
    <link rel="stylesheet" href="./newffff/CSS/style.css">

</head>

<body class="bg-gradiant-green-blue">
    <div class="login">
        <h1 class="text-center"> سامانه حسابداری </h1>

        <section class="bg-light my-0 px-2">
            <?php if (isset($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
            <small class="text-danger"><?= $error . '<br>' ?></small>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <form method="POST" action="login.php" class="needs-validation">
            <div class="form-group">
                <label class="form-label" for="username"> نام کاربری </label>
                <input class="form-control" type="text" id="username" name="username"
                    <?php
                                                                                        if (isset($_COOKIE['username']) && !(empty($_COOKIE['username']))) : ?>
                    value="<?= $_COOKIE['username'] ?>" <?php endif; ?>>
            </div>

            <div class="form-group">
                <label class="form-label" for="password"> کلمه عبور </label>
                <input class="form-control" type="password" id="password" name="password"
                    <?php
                                                                                            if (isset($_COOKIE['password']) && !(empty($_COOKIE['password']))) : ?>
                    value="<?= $_COOKIE['password'] ?>" <?php endif; ?>>
            </div>

            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                <label class="form-check-label" for="check">Remember me</label>
            </div>

            <input class="btn btn-success w-100" name="submit" type="submit" value="Login">
            <?php
            if ($token) {
                echo "
            <script>
            setTimeout(function() {
                swal('عزیز خوش آمدید {$user->user_name}','تا لحظاتی دیگر به داشبورد منتقل می شوید','success')
            }, 1);
            window.setTimeout(function() {
                window.location.replace('./index.php');
            }, 3000);
            </script>
            ";
            }
            ?>
        </form>


    </div>
    <script src='./newffff/JS/sweet-alert.min.js'></script>

</body>

</html>