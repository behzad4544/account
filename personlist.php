<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
global $db;
// $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty,buyfactor.factor_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.  "
$sql = "SELECT * from personaccount where account_type ='1'";
$stmt = $db->prepare($sql);
$stmt->execute();
$persons = $stmt->fetchAll();

$sql = "SELECT * from personaccount where account_type ='3'";
$stmt = $db->prepare($sql);
$stmt->execute();
$banks = $stmt->fetchAll();

$sql = "SELECT * from personaccount where account_type ='2'";
$stmt = $db->prepare($sql);
$stmt->execute();
$details = $stmt->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/JS/bootstrap.min.js">
    <!-- icon font -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body dir="rtl">
    <p>کاردکس اشخاص</p>
    <table id="myTable2" style="border: 1px solid">
        <tr>
            <th style=" border: 1px solid">ردیف</th>
            <th style=" border: 1px solid">نام شخص</th>
            <th style=" border: 1px solid">مانده </th>
            <th style=" border: 1px solid">بدهکار / بستانکار </th>
        </tr>
        <?php $i = 1;
foreach ($persons as $person) {?>
        <tr>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $person->cust_id ?>"><?= $i ?></a>
            </td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $person->cust_id ?>"><?= $person->cust_name ?></a></td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $person->cust_id ?>"><?= abs($person->total_credit) ?></a></td>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $person->cust_id ?>"><?php if(($person->total_credit)> 0) {
                echo "بستانکار";
            } elseif (($person->total_credit) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></a></td>
        </tr>
        <?php ++$i;
} ?>
    </table>


    <p>کاردکس بانک ها</p>
    <table id="myTable2" style="border: 1px solid">
        <tr>
            <th style=" border: 1px solid">ردیف</th>
            <th style=" border: 1px solid">نام بانک</th>
            <th style=" border: 1px solid">مانده </th>
            <th style=" border: 1px solid">بدهکار / بستانکار </th>
        </tr>
        <?php $i = 1;
foreach ($banks as $bank) {?>
        <tr>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $bank->cust_id ?>"><?= $i ?></a>
            </td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $bank->cust_id ?>"><?= $bank->cust_name ?></a></td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $bank->cust_id ?>"><?= abs($bank->total_credit) ?></a></td>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $bank->cust_id ?>"><?php if(($bank->total_credit)> 0) {
                echo "بستانکار";
            } elseif (($bank->total_credit) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></a></td>
        </tr>
        <?php ++$i;
} ?>
    </table>


    <p>کاردکس خرید و فروش </p>
    <table id="myTable2" style="border: 1px solid">
        <tr>
            <th style=" border: 1px solid">ردیف</th>
            <th style=" border: 1px solid">نام حساب</th>
            <th style=" border: 1px solid">مانده </th>
            <th style=" border: 1px solid">بدهکار / بستانکار </th>
        </tr>
        <?php $i = 1;
foreach ($details as $detail) {?>
        <tr>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $detail->cust_id ?>"><?= $i ?></a>
            </td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $detail->cust_id ?>"><?= $detail->cust_name ?></a></td>
            <td style=" border: 1px solid"><a
                    href="./persondetail.php?id=<?= $detail->cust_id ?>"><?= number_format(abs($detail->total_credit)) ?></a>
            </td>
            <td style=" border: 1px solid"><a href="./persondetail.php?id=<?= $detail->cust_id ?>"><?php if(($detail->total_credit)> 0) {
                echo "بستانکار";
            } elseif (($detail->total_credit) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></a></td>
        </tr>
        <?php ++$i;
} ?>
    </table>


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