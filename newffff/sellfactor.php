<?php
require "./Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./Helper/helpers.php";
global $db;
if (isset($_POST['submit'])) {
    date_default_timezone_set('Iran');
    $realTimestamp = substr($_POST['buy_date'], 0, 10);
    $total = ((int)$_POST['product_qty'] * (int)$_POST['factor_fi']) - (int)$_POST['sell_off'];
    $sql = 'INSERT INTO `sellfactors` SET sell_date=?,cust_id=?,product_id=?,product_qty=?,factor_fi=?,sell_off=?,sell_sum=?,factor_explanation=?,user_editfactor=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['sell_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id']]);
    if ($stmt) {
        echo "ثبت شد";
    } else {
        echo "ثبت نشد";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Factor</title>
    <!-- swiper css link -->
    <link rel="stylesheet" href="./CSS/swiper-bundle.min.css" />
    <link rel='stylesheet' href='./CSS/sweet-alert.css'>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css" />
    <link href="Public/jalalidatepicker/persian-datepicker.min.css" rel="stylesheet" type="text/css">


    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="./CSS/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="./CSS/style3.css">

</head>

<body>
    <div class="heading" style="background:url(./CSS/purchase2.png) no-repeat">
        <h1> فاکتور فروش </h1>
    </div>

    <!-- purchasing section starts -->

    <section class="booking">
        <h1 class="heading-title"></h1>

        <form action="" method="POST" class="book-form">
            <div class="flex">
                <div class="inputBox">
                    <span> نام خریدار: </span>
                    <select name="cust_id" class="inputBox">
                        <option>لطفا یکی از خریداران زیر را انتخاب فرمایید</option>
                        <option value="1" class="inputBox">Behzad</option>
                        <option value="2" class="inputBox">fatemeh</option>
                        <option value="3" class="inputBox">ArmanGostar</option>
                    </select>
                </div>
                <div class="inputBox">

                    <span> نام کالا: </span>
                    <select name="product_id" class="inputBox">
                        <option>لطفا یکی از کالاهای زیر را انتخاب فرمایید</option>
                        <option value="1" class="inputBox">laptop</option>
                        <option value="2" class="inputBox">mobile</option>
                        <option value="3" class="inputBox">tablet</option>
                    </select>

                </div>
                <div class="inputBox">
                    <span>تعداد کالا : </span>
                    <input type="number" placeholder="تعداد کالا" name="product_qty">
                </div>
                <div class="inputBox">
                    <span>قیمت هر کالا: </span>
                    <input type="text" placeholder="قیمت فی کالا به تومان" name="factor_fi">
                </div>
                <div class="inputBox">
                    <span>تخفیف:</span>
                    <input type="text" placeholder="مقدار تخفیف به تومان" name="sell_off">
                </div>
                <!-- <div class="inputBox">
                    <span>تاریخ خرید : </span>
                    <input type="date" name="date">
                </div> -->
                <div class="inputBox">
                    <span>تاریخ فروش :</span>
                    <input type="text" class="form-control d-none" id="sell_date" name="sell_date" required autofocus>
                    <input type="text" class="form-control" id="date_view" required autofocus>
                </div>
                <div class="inputBox">
                    <span> توضیحات فروش:</span>
                    <textarea name="factor_explanation" rows="5" cols="45"></textarea>
                </div>


            </div>

            <input type="submit" value="ثبت فاکتور" class="btn" name="submit">

        </form>
    </section>

    <script src="./JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./JS/bootstrap.min.js"></script>
    <script src="./Public/jalalidatepicker/persian-date.min.js"></script>
    <script src="./Public/jalalidatepicker/persian-datepicker.min.js"></script>
    <script src='./JS/sweet-alert.min.js'></script>
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
                altField: '#sell_date'

            })
        });
    </script>

</body>