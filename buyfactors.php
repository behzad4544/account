<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
global $i;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}

$sql = "SELECT buyfactor.*,credits.credit_after FROM buyfactor,credits WHERE buyfactor.buyfactor_id = credits.buyfactor_id AND credits.personaccount_id = '2'";
$stmt = $db->prepare($sql);
$stmt->execute([]);
$buyfactors = $stmt->fetchAll();


$sql = "SELECT total_credit FROM personaccount WHERE account_type=? AND cust_name=?";
$stmt = $db->prepare($sql);
$stmt->execute(["2","خرید"]);
$Total = $stmt->fetch();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Factors</title>
    <link rel="stylesheet" href="./assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/JS/bootstrap.min.js">
    <!-- icon font -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body dir="rtl">

    <p>
        نمایش فاکتورهای خرید
    </p>
    <table id="detailTable" style=" border: 1px solid">
        <tr style=" border: 1px solid">
            <th onclick="sortTable(0)" style=" border: 1px solid">ردیف</th>
            <th onclick="sortTable(1)" style=" border: 1px solid">تاریخ عملیات</th>
            <th onclick="sortTable(2)" style=" border: 1px solid">شماره فاکتور </th>
            <th onclick="sortTable(3)" style=" border: 1px solid">مبلغ فاکتور</th>
            <th onclick="sortTable(4)" style=" border: 1px solid">وضعیت</th>
            <th onclick="sortTable(5)" style=" border: 1px solid">عملیات</th>
        </tr>


        <?php $i = 1;
foreach ($buyfactors as $buyfactor) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d", $buyfactor->buy_date) ?> </td>
            <td style=" border: 1px solid"><a href="./buyfactorpre.php?id=<?= $buyfactor->buyfactor_id ?>">فاکتور خرید
                    شماره
                    <?= $buyfactor->buyfactor_id ?></a></td>
            <td style=" border: 1px solid"><?= number_format(abs($buyfactor->buy_sum)) ?></td>
            <td style=" border: 1px solid"><span
                    class="text-success"><?= ($buyfactor-> factor_done == "2") ? "تسویه شده" : "" ?></span>
                <span class="text-danger"><?= ($buyfactor-> factor_done != "2") ? "تسویه نشده" : "" ?></span>
            </td>
            <td style=" border: 1px solid"><a href="#" class="btn btn-warning btn-sm">تغییر وضعیت</a>
                <a href="#" class="btn btn-info btn-sm">ویرایش فاکتور</a>
                <a href="#" class="btn btn-danger btn-sm">پاک کردن فاکتور</a>
            </td>
        </tr>
        <?php ++$i;
} ?>

        <p>
            جمع کل خریدها : <?= number_format(abs($Total->total_credit)) ?>
        </p>


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