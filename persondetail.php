<?php
require "./newffff/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
require "./newffff/Helper/jdf.php";
global $i;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
if (isset($_GET['id']) && !(empty($_GET['id']))) {
    $id = $_GET['id'];
    $sql = "SELECT * from personaccount WHERE cust_id =?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $person = $stmt->fetch();
    if ($person == null) {
        header("location:personlist.php");
    } else {
        // $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty as buy_qty,buyfactor.factor_fi as buy_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.product_id=sellfactors.product_id and buyfactor.product_id=? and sellfactors.product_id=? order by ";
        $sql = "SELECT buyfactor.buyfactor_id,buyfactor.cust_id,buyfactor.buy_date,buyfactor.buy_sum,credits.credit_after from buyfactor,credits where buyfactor.cust_id=? and buyfactor.cust_id=credits.personaccount_id and credits.buyfactor_id = buyfactor.buyfactor_id   order by buyfactor.buy_date ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $buys = $stmt->fetchAll();


        $sql = "SELECT sellfactors.sellfactor_id,sellfactors.sell_date,sellfactors.sell_sum,credits.credit_after from sellfactors,credits where sellfactors.cust_id=? and sellfactors.cust_id=credits.personaccount_id and credits.sellfactor_id = sellfactors.sellfactor_id order by sellfactors.sell_date ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $sells = $stmt->fetchAll();


        $sql = "SELECT transfer.*,credits.credit_after from transfer,credits where transfersend_from = ? and transfer.transfersend_id =credits.transfer_id and transfer.transfersend_from =credits.personaccount_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $transfers_from = $stmt->fetchAll();



        $sql = "SELECT transfer.*,credits.credit_after from transfer,credits where transfersend_to = ?and transfer.transfersend_id =credits.transfer_id and transfer.transfersend_to =credits.personaccount_id ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $transfers_to = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./newffff/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./newffff/JS/bootstrap.min.js">
    <!-- icon font -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body dir="rtl">
    <p>
        نمایش کاردکس <?= $person->cust_name ?>
    </p>
    <table id="detailTable" style=" border: 1px solid">
        <tr style=" border: 1px solid">
            <th onclick="sortTable(0)" style=" border: 1px solid">ردیف</th>
            <th onclick="sortTable(1)" style=" border: 1px solid">تاریخ عملیات</th>
            <th onclick="sortTable(2)" style=" border: 1px solid">شماره سند مربوطه </th>
            <th onclick="sortTable(3)" style=" border: 1px solid">مبلغ بستانکاری</th>
            <th onclick="sortTable(4)" style=" border: 1px solid">مبلغ بدهکاری </th>
            <th onclick="sortTable(5)" style=" border: 1px solid">مانده</th>
            <th onclick="sortTable(6)" style=" border: 1px solid">وضعیت کلی</th>
        </tr>


        <?php $i = 1;
foreach ($buys as $buy) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d h:i:s", $buy->buy_date) ?> </td>
            <td style=" border: 1px solid"><a href="./buyfactorpre.php?id=<?= $buy->buyfactor_id ?>">فاکتور خرید شماره
                    <?= $buy->buyfactor_id ?></a></td>
            <td style=" border: 1px solid"><?= abs($buy->buy_sum) ?></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= abs($buy->credit_after) ?></td>
            <td style=" border: 1px solid"><?php if(($buy->credit_after) > 0) {
                echo "بستانکار";
            } elseif (($buy->credit_after) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></td>
        </tr>


        <?php  ++$i;
} ?>
        <?php ;
foreach ($sells as $sell) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d h:i:s", $sell->sell_date) ?> </td>
            <td style=" border: 1px solid"><a href="./sellfactorpre.php?id=<?= $sell->sellfactor_id ?>">فاکتور فروش
                    شماره <?= $sell->sellfactor_id ?></a></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= abs($sell->sell_sum) ?></td>
            <td style=" border: 1px solid"><?= abs($sell->credit_after) ?></td>
            <td style=" border: 1px solid"><?php if(($sell->credit_after) > 0) {
                echo "بستانکار";
            } elseif (($sell->credit_after) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></td>
        </tr>
        <?php ++$i;
} ?>
        <?php ;
foreach ($transfers_from as $transfer_from) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d h:i:s", $transfer_from->transfersend_date) ?> </td>
            <td style=" border: 1px solid"><a href="#"> حواله
                    شماره <?= $transfer_from->transfersend_id ?></a></td>
            <td style=" border: 1px solid"><?= abs($transfer_from->transfersend_price) ?></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= abs($transfer_from->credit_after) ?></td>
            <td style=" border: 1px solid"><?php if(($transfer_from->credit_after) > 0) {
                echo "بستانکار";
            } elseif (($transfer_from->credit_after) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></td>
        </tr>
        <?php ++$i;
} ?>
        <?php ;
foreach ($transfers_to as $transfer_to) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d h:i:s", $transfer_to->transfersend_date) ?> </td>
            <td style=" border: 1px solid"><a href="#"> حواله
                    شماره <?= $transfer_to->transfersend_id ?></a></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= abs($transfer_to->transfersend_price) ?></td>
            <td style=" border: 1px solid"><?= abs($transfer_to->credit_after) ?></td>
            <td style=" border: 1px solid"><?php if(($transfer_to->credit_after) > 0) {
                echo "بستانکار";
            } elseif (($transfer_to->credit_after) == 0) {
                echo "-";
            } else {
                echo "بدهکار";
            } ?></td>
        </tr>
        <?php ++$i;
} ?>
    </table>
    <p>
        مانده کل <?= $person->cust_name ?> : <?= abs($person->total_credit) ?>
        <?php if(($person->total_credit) > 0) {
            echo "بستانکار";
        } elseif (($person->total_credit) == 0) {
            echo "-";
        } else {
            echo "بدهکار";
        } ?></p>
    <script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("detailTable");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "asc";
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    </script>
    <footer class="text-center mt-4">
        <div class="btn-group btn-group-sm ">
            <a href="./personlist.php" class="btn btn-light border">
                برگشت به لیست اشخاص
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