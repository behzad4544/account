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
    $unit=$_POST['unit_product'];
    $sql = "SELECT * FROM units WHERE unit_name =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$unit]);
    $units = $stmt->fetch();
    if($units == null) {
        $token = 1;
        $sql = "INSERT INTO units SET unit_name=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$unit]);
    } else {
        $token = 0;
        $errors[] = "این واحد کالا در سیستم موجود می باشد";
    }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Unit</title>
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
        <h1> تعریف واحد کالای جدید </h1>
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
                    <span>واحد کالا : </span>
                    <input type="text" placeholder="واحد کالا" name="unit_product">
                </div>

            </div>

            <input type="submit" value="ثبت واحد کالا" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1 && $token ==1) {
                echo "
        <script>
        setTimeout(function() {
            swal('واحد {$_POST['unit_product']} اضافه شد','تا لحظاتی دیگر به داشبورد منتقل می شوید', 'success')
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