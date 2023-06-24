<?php
require "./newffff/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
require "./newffff/Helper/jdf.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
} else {
    if (isset($_GET['id']) && !(empty($_GET['id']))) {
        $id = $_GET['id'];
        $sql = "SELECT * from transfer WHERE transfersend_id =?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $transfer = $stmt->fetch();
        if ($transfer == null) {
            header("location:index.php");
        } else {
            $sql = "SELECT transfer.transfersend_date, personaccount.cust_name, transfer.transfersend_price,personaccount.total_credit from transfer,personaccount WHERE transfer.transfersend_from = personaccount.cust_id and transfer.transfersend_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $bestankar = $stmt->fetch();

            $sql = "SELECT transfer.transfersend_date, personaccount.cust_name, transfer.transfersend_price,personaccount.total_credit from transfer,personaccount WHERE transfer.transfersend_to = personaccount.cust_id and transfer.transfersend_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $bedehkar = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>havaleView</title>
    <!-- swiper css link -->
    <link rel="stylesheet" href="./newffff/CSS/swiper-bundle.min.css" />
    <link rel='stylesheet' href='./newffff/CSS/sweet-alert.css'>
    <link rel="stylesheet" href="./newffff/CSS/bootstrap.min.css" />
    <link href="./newffff/Public/jalalidatepicker/persian-datepicker.min.css" rel="stylesheet" type="text/css">


    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="./newffff/CSS/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="./newffff/CSS/style3.css">

</head>

<body>
    <p>
        نمایش حواله شماره <?= $id ?>
    </p>
    <p>
        تاریخ حواله : <?= jdate("Y/m/d", $bestankar->transfersend_date) ?>
    </p>

    <table style=" border: 1px solid">
        <tr style=" border: 1px solid">
            <th style=" border: 1px solid">طرف حساب</th>
            <th style=" border: 1px solid">بستانکار</th>
            <th style=" border: 1px solid">بدهکار</th>
        </tr>
        <tr style=" border: 1px solid">
            <td style=" border: 1px solid"> <?= $bestankar->cust_name ?> </td>
            <td style=" border: 1px solid"> <?= $bestankar->transfersend_price ?></td>
            <td style=" border: 1px solid"> 0 </td>
        </tr>
        <tr style=" border: 1px solid">
            <td style=" border: 1px solid"> <?= $bedehkar->cust_name ?> </td>
            <td style=" border: 1px solid"> 0 </td>
            <td style=" border: 1px solid"> <?= $bedehkar->transfersend_price ?></td>
        </tr>
    </table>

    <p>توضیحات حواله : </p>
    <p>
        <?= $transfer-> transfersend_explanation ?>
    </p>

    <p> مانده <?= $bestankar->cust_name ?> تا این تاریخ : <?= abs($bestankar->total_credit) ?>
        <?php if(($bestankar->total_credit)> 0) {
            echo "بستانکار";
        } else {
            echo "بدهکار";
        } ?></p>
    <p> مانده <?= $bedehkar->cust_name ?> تا این تاریخ : <?= abs($bedehkar->total_credit) ?> <?php if(($bestankar->total_credit)< 0) {
        echo "بستانکار";
    } else {
        echo "بدهکار";
    } ?></p>

    <footer class="text-center mt-4">
        <div class="btn-group btn-group-sm ">
            <a href="./index.php" class="btn btn-light border">
                برگشت به داشبورد
            </a>
            <a href="javascript:window.print()" class="btn btn-light border">
                <ion-icon name="print-outline"></ion-icon> پرینت
            </a>
            <a href="javascript:window.print()" class="btn btn-light border">
                <ion-icon name="download-outline"></ion-icon> دانلود
            </a>

        </div>

    </footer>
</body>

</html>