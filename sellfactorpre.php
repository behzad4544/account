<?php
require "./newffff/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
require "./newffff/Helper/jdf.php";
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
global $db;
if (isset($_GET['id']) && !(empty($_GET['id']))) {
    $id = $_GET['id'];
    $sql = "SELECT sellfactors.sellfactor_id,sellfactors.product_id,sellfactors.sell_date,sellfactors.user_editfactor,personaccount.cust_name,personaccount.cust_id,products.product_name,sellfactors.product_qty,sellfactors.factor_fi,sellfactors.sell_off,sellfactors.sell_sum,sellfactors.factor_explanation,users.user_name FROM sellfactors,wearhouses,personaccount,products,users WHERE sellfactors.cust_id = personaccount.cust_id and sellfactors.product_id=products.product_id and sellfactors.user_editfactor = users.user_id and sellfactors.sellfactor_id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $factor = $stmt->fetch();
    if ($factor == null) {
        header("location:index.php");
    } else {
        $sql = "SELECT SUM(credit) as credit from credits where personaccount_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$factor->cust_id]);
        $credits = $stmt->fetch();
        $sql = 'SELECT wearhouses.wearhouse_name from buyfactor,wearhouses where buyfactor.warehouse_id=wearhouses.wearhouse_id and  product_id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$factor->product_id]);
        $warehouse = $stmt->fetch();
        $anbar = $warehouse->wearhouse_name;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./newffff/CSS/style.css">
    <link rel="stylesheet" href="./newffff/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./newffff/JS/bootstrap.min.js">
    <!-- icon font -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="container-fluid invoice-container">
        <header>
            <div class="row align-items-center">
                <div class="col-sm-7">
                    <img id="logo" src="./newffff/CSS/LOGO.jpg" alt="">
                </div>
                <div class="col-sm-5 text-right">
                    <h4 class="mb-0 text-right"> :فاکتور فروش </h4>

                </div>
            </div>
        </header>
        <main>
            <div class="row">
                <div class="col-sm-6 "><strong> تاریخ:</strong> <?= jdate("Y/m/d", $factor->sell_date) ?> </div>
                <div class="col-sm-6 text-right"><strong>شماره فاکتور:</strong><?= $factor->sellfactor_id ?></div>
                <div class="col-sm-6 text-left"><strong> نام انبار:</strong><?= $anbar ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6 text-right order-sm-1"><strong> :نام ثبت کننده فاکتور</strong>
                    <address>
                        <?= $factor->user_name  ?><br>
                    </address>
                </div>


                <div class="col-sm-6 order-sm-0"><strong>:نام مشتری</strong>
                    <address>
                        <?= $factor->cust_name  ?> <br>
                    </address>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="card-header">
                                <tr>
                                    <td class="col-3 text-center"><strong> مبلغ کل(تومان)</strong></td>
                                    <td class="col-3 text-center"><strong>فی کالا</strong></td>
                                    <td class="col-3 text-center"><strong>تعداد کالا</strong></td>
                                    <td class="col-3 text-center"><strong>نام کالا </strong></td>
                                    <td class="col-3 text-center"><strong>ردیف</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-3 text-center">
                                        <strong><?= ($factor->factor_fi * $factor->product_qty)  ?></strong>
                                    </td>
                                    <td class="col-3 text-center"><strong><?= $factor->factor_fi  ?></strong></td>
                                    <td class="col-3 text-center"><strong><?= $factor->product_qty  ?></strong></td>
                                    <td class="col-3 text-center"><strong><?= $factor->product_name  ?></strong></td>
                                    <td class="col-3 text-center"><strong>1</strong></td>
                                </tr>

                            </tbody>
                            <tfoot class="card-footer">
                                <tr>
                                    <td class="text-center"><strong><?= $factor->sell_off ?></strong></td>
                                    <td colspan="4" class="text-left"><strong> :مبلغ تخفیف </strong></td>
                                </tr>

                                <tr>
                                    <td class="text-center"><strong> <?= $factor->sell_sum   ?> </strong></td>
                                    <td colspan="4" class="text-left"><strong> : مبلغ کل فاکتور </strong></td>

                                </tr>

                                <tr>
                                    <td class="text-center"><strong> <?php
                                                                        if (($credits->credit) > 0) {
                                                                            echo "(بستانکار)";
                                                                        } else {
                                                                            echo "(بدهکار)";
                                                                        }
?> <?= $credits->credit ?> </strong></td>
                                    <td colspan="4" class="text-left"><strong> : مانده <?= $factor->cust_name  ?> تا این
                                            تاریخ
                                        </strong></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        </main>
        <footer class="text-right mt-4">
            <p class="text-1"><strong> :توضیحات</strong></p>
            <p class="text-1"><?= $factor->factor_explanation  ?></p>

        </footer>
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

    </div>
</body>

</html>