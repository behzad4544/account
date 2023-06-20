<?php
require "./Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./Helper/helpers.php";
global $db;
$sql = "SELECT * FROM personaccount where account_type=?";
$stmt = $db->prepare($sql);
$stmt->execute([1]);
$customers = $stmt->fetchAll();
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
$sql = "SELECT * FROM wearhouses";
$stmt = $db->prepare($sql);
$stmt->execute();
$wearhouses = $stmt->fetchAll();
if (isset($_POST['submit'])) {
    date_default_timezone_set('Iran');
    $realTimestamp = substr($_POST['buy_date'], 0, 10);
    $total = ((int)$_POST['product_qty'] * (int)$_POST['factor_fi']) - (int)$_POST['buy_off'];
    $sql = 'INSERT INTO `buyfactor` SET buy_date=?,cust_id=?,product_id=?,warehouse_id=?,product_qty=?,factor_fi=?,buy_off=?,buy_sum=?,factor_explanation=?,user_editfactor=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['warehouse_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['buy_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id']]);
    $id = $db->lastInsertId();
    $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['cust_id'], (int)$total, $id, $realTimestamp, $_SESSION['user_id']]);
    $id1 = $db->lastInsertId();
    $sql = 'SELECT * from personaccount where cust_name=?';
    $buy1 = 'خرید';
    $stmt = $db->prepare($sql);
    $stmt->execute([$buy1]);
    $buy2 = $stmt->fetch();
    $buy = $buy2->cust_id;
    $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$buy, -(int)$total, $id, $realTimestamp, $_SESSION['user_id']]);
    $id2 = $db->lastInsertId();
    $sql = 'SELECT * FROM personaccount where cust_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['cust_id']]);
    $supplier = $stmt->fetch();
    $supp = $supplier->cust_name;
    $sql = "SELECT * from stocks where stock_productid=? and stock_wearhouseid=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['product_id'],(int)$_POST['warehouse_id']]);
    $res = $stmt->fetchAll();
    if($res == null) {
        $sql = 'INSERT INTO stocks SET stock_productid=?,stock_wearhouseid=?,stock=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['product_id'],(int)$_POST['warehouse_id'],(int)$_POST['product_qty']]);
    } else {

        $sql= "SELECT stock FROM stocks where stock_productid=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['product_id']]);
        $oldstock= $stmt->fetch();
        $newstock = (int)$oldstock->stock + (int)$_POST['product_qty'];
        $sql = "UPDATE stocks SET stock=? where stock_productid=? and stock_wearhouseid=?  " ;
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$newstock,(int)$_POST['product_id'],(int)$_POST['warehouse_id']]);

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Factor</title>
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
        <h1> فاکتور خرید </h1>
    </div>

    <!-- purchasing section starts -->

    <section class="booking">
        <h1 class="heading-title"></h1>
        <form action="" method="POST" class="book-form">
            <div class="flex">
                <div class="inputBox">
                    <span> نام تامین کننده: </span>
                    <select name="cust_id" class="inputBox">
                        <option>لطفا یکی از تامین کنندگان زیر را انتخاب فرمایید</option>
                        <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer->cust_id ?>" class="inputBox"><?= $customer->cust_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="inputBox">

                    <span> نام کالا: </span>
                    <select name="product_id" class="inputBox">
                        <option>لطفا یکی از کالاهای زیر را انتخاب فرمایید</option>
                        <?php foreach($products as $product): ?>
                        <option value="<?= $product->product_id ?>" class="inputBox"><?= $product->product_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="inputBox">
                    <span>نام انبار: </span>
                    <select name="warehouse_id" class="inputBox">
                        <option>لطفا یکی از انبارهای زیر را انتخاب فرمایید</option>
                        <?php foreach($wearhouses as $wearhouse): ?>
                        <option value="<?= $wearhouse->wearhouse_id ?>" class="inputBox">
                            <?= $wearhouse->wearhouse_name ?>
                        </option>
                        <?php endforeach; ?>
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
                    <input type="text" placeholder="مقدار تخفیف به تومان" name="buy_off">
                </div>
                <!-- <div class="inputBox">
                    <span>تاریخ خرید : </span>
                    <input type="date" name="date">
                </div> -->
                <div class="inputBox">
                    <span>تاریخ خرید :</span>
                    <input type="text" class="form-control d-none" id="buy_date" name="buy_date" required autofocus>
                    <input type="text" class="form-control" id="date_view" required autofocus>
                </div>
                <div class="inputBox">
                    <span> توضیحات خرید:</span>
                    <textarea name="factor_explanation" rows="5" cols="45"></textarea>
                </div>


            </div>

            <input type="submit" value="ثبت فاکتور" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1) {
                echo "
        <script>
        setTimeout(function() {
            swal('فاکتور خرید شماره {$id} ثبت شد ', 'حواله شماره {$id1} برای طرف حساب {$supp} و همچنین حواله شماره {$id2} برای حساب خرید ثبت شد', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('../buyfactorpre.php?id={$id}');
        }, 8000);
        </script>
        ";
            }
?>
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
            altField: '#buy_date'
        })
    });
    </script>


</body>

</html>