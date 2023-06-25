<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}

if (isset($_POST['submit'])) {
    $errors = [];
    date_default_timezone_set('Iran');

    $sql = "SELECT * FROM personaccount where cust_name=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['cust_name']]);
    $person = $stmt->fetch();

    if($person == null) {
        $token = 1;
        $sql = "INSERT INTO personaccount SET account_type=?,cust_name=?,cust_codemeli=?,cust_address=?,cust_mobile=?,total_credit=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['account_type'],$_POST['cust_name'],$_POST['cust_codemeli'],$_POST['cust_address'],$_POST['cust_mobile'],$_POST['total_credit']]);
    } else {
        $token = 0;
        $errors[] = "این شخص / طرف حساب در سیستم موجود می باشد";
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
        <h1> تعریف طرف حساب یا صندوق جدید </h1>
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
                    <span> نام طرف حساب یا صندوق: </span>
                    <input type="text" placeholder="نام طرف حساب را وارد کنید" name="cust_name">
                </div>
                <div class="inputBox">
                    <span>کد ملی / شناسه ملی / شماره حساب : </span>
                    <input type="text" placeholder="کد ملی / شناسه ملی / شماره حساب را وارد کنید " name="cust_codemeli">
                </div>
                <div class="inputBox">
                    <span> شماره تماس : </span>
                    <input type="text" placeholder="  شماره تماس را وارد کنید" name="cust_mobile">
                </div>
                <div class="inputBox">
                    <span>مانده از قبل : </span>
                    <input type="text" placeholder="در صورتی که شخص به شما بدهکار است مانده را منفی وارد کنید"
                        name="total_credit">
                </div>
                <div class="inputBox">
                    <span> طرف حساب </span>
                    <input type="radio" name="account_type" value="1">
                    <span> صندوق / بانک </span>
                    <input type="radio" name="account_type" value="3">
                </div>
                <div class="inputBox">
                    <span> آدرس : </span>
                    <textarea name="cust_address" rows="5" cols="45"></textarea>
                </div>

            </div>

            <input type="submit" value="ثبت طرف حساب / صندوق" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1 && $token ==1) {
                echo "
        <script>
        setTimeout(function() {
            swal('طرف حساب / بانک {$_POST['cust_name']} اضافه شد','تا لحظاتی دیگر به داشبورد منتقل می شوید', 'success')
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