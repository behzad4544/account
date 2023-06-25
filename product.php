<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}


$sql = "SELECT * FROM units ";
$stmt = $db->prepare($sql);
$stmt->execute();
$units = $stmt->fetchAll();

$sql = "SELECT * FROM categories ";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();


if (isset($_POST['submit'])) {
    $errors = [];
    date_default_timezone_set('Iran');

    $sql = "SELECT * FROM products where product_name=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['product_name']]);
    $products = $stmt->fetch();


    if($products == null) {
        $token = 1;
        $sql = "INSERT INTO products SET product_name=?,product_serial=?,category_id=?,unit_id=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['product_name'],$_POST['product_serial'],$_POST['category_id'],$_POST['unit_id']]);
    } else {
        $token = 0;
        $errors[] = "این کالا در سیستم موجود می باشد";
    }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
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
        <h1> تعریف کالای جدید </h1>
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
                    <span>نام کالا : </span>
                    <input type="text" placeholder="نام کالا" name="product_name">
                </div>
                <div class="inputBox">
                    <span>سریال کالا : </span>
                    <input type="text" placeholder="سریال کالا" name="product_serial">
                </div>
                <div class="inputBox">
                    <span> نام دسته بندی : </span>
                    <select name="category_id" class="inputBox">
                        <option>لطفا یکی از دسته بندی های زیر را انتخاب فرمایید</option>
                        <?php foreach ($categories as $categori): ?>
                        <option value="<?= $categori->category_id ?>" class="inputBox"><?= $categori->category_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="inputBox">
                    <span> نام واحد کالا: </span>
                    <select name="unit_id" class="inputBox">
                        <option>لطفا یکی از واحدهای زیر را انتخاب فرمایید</option>
                        <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit->unit_id ?>" class="inputBox"><?= $unit->unit_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <input type="submit" value="ثبت واحد کالا" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1 && $token ==1) {
                echo "
        <script>
        setTimeout(function() {
            swal('کالای {$_POST['product_name']} اضافه شد','تا لحظاتی دیگر به داشبورد منتقل می شوید', 'success')
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