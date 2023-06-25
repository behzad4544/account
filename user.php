<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}

$sql = "SELECT * FROM permitions";
$stmt = $db->prepare($sql);
$stmt->execute();
$permitions = $stmt->fetchAll();

if (isset($_POST['submit'])) {
    $errors = [];
    date_default_timezone_set('Iran');
    $sql = "SELECT * FROM users where user_name=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['user_name']]);
    $person = $stmt->fetch();

    if($person == null) {
        if($_POST['user_password']===$_POST['user_password_two']) {
            $pass_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
            $sql = "SELECT * FROM permitions WHERE permition_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['permition_id']]);
            $permision = $stmt->fetch();
            $token = 1;
            $sql = "INSERT INTO users SET user_name=?,user_firstName=?,user_email =?,user_password=?,permition_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['user_name'],$_POST['user_firstName'],$_POST['user_email'],$pass_hash,$_POST['permition_id']]);
        } else {
            $token = 0;
            $errors[] = "رمزها یکسان نمی باشد";
        }
    } else {
        $token = 0;
        $errors[] = "این کاربر در سیستم موجود می باشد";
    }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account</title>
    <!-- swiper css link -->
    <link rel="stylesheet" href="./assets/CSS/swiper-bundle.min.css" />
    <link rel='stylesheet' href='./assets/CSS/sweet-alert.css'>
    <link rel="stylesheet" href="./assets/CSS/bootstrap.min.css" />
    <link href="./assets/Public/jalalidatepicker/persian-datepicker.min.css" rel="stylesheet" type="text/css">


    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="./assets/CSS/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="./assets/CSS/style3.css">

</head>

<body>
    <div class="heading" style="background:url(./assets/CSS/purchase2.png) no-repeat">
        <h1>تعریف کاربر جدید سیستم</h1>
    </div>
    <section class="bg-light my-0 px-2">
        <?php if (isset($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
        <small class="text-danger"><?= $error . '<br>' ?></small>
        <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- purchasing section starts -->

    <section class="booking">
        <h1 class="heading-title"></h1>
        <form action="" method="POST" class="book-form">
            <div class="flex">
                <div class="inputBox">
                    <span> نام کاربری: </span>
                    <input type="text" placeholder="نام کاربری را وارد کنید" name="user_name">
                </div>
                <div class="inputBox">
                    <span>نام و نام خانوادگی: </span>
                    <input type="text" placeholder="نام و نام خانوادگی را وارد کنید " name="user_firstName">
                </div>
                <div class="inputBox">
                    <span> ایمیل : </span>
                    <input type="text" placeholder="ایمیل را وارد کنید" name="user_email">
                </div>
                <div class="inputBox">
                    <span> دسترسی: </span>
                    <select name="permition_id" class="inputBox">
                        <option>لطفا یکی از دسترسی های زیر را انتخاب فرمایید</option>
                        <?php foreach($permitions as $permition): ?>
                        <option value="<?= $permition->permition_id ?>" class="inputBox">
                            <?= $permition->permition_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="inputBox">
                    <span> رمز عبور : </span>
                    <input type="password" placeholder="پسورد را وارد کنید" name="user_password">
                </div>
                <div class="inputBox">
                    <span> تایید رمز عبور : </span>
                    <input type="password" placeholder="پسورد را دوباره وارد کنید" name="user_password_two">
                </div>

            </div>

            <input type="submit" value="ثبت کاربر" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1 && $token ==1) {
                echo "

                
                
        <script>
        setTimeout(function() {
            swal('یک کاربر با نام کاربری {$_POST['user_firstName']} و سطح دسترسی {$permision->permition_name} ثبت شد','تا لحظاتی دیگر به داشبورد منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./index.php');
        }, 5000);
        </script>
        ";
            }
?>
        </form>
    </section>

    <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./assets/JS/bootstrap.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-date.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-datepicker.min.js"></script>
    <script src='./assets/JS/sweet-alert.min.js'></script>
    <script>
    $(document).ready(function() {
        $("#date_view").persianDatepicker({
            format: 'YYYY-MM-DD',
            toolbax: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '#buy_date'
        })
    });
    </script>


</body>

</html>