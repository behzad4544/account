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
    $sql = "SELECT * from products WHERE product_id =?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if ($product == null) {
        header("location:productlist.php");
    } else {
        // $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty as buy_qty,buyfactor.factor_fi as buy_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.product_id=sellfactors.product_id and buyfactor.product_id=? and sellfactors.product_id=? order by ";
        $sql = "SELECT buyfactor.buyfactor_id,buyfactor.credit_prod_after,buyfactor.buy_date,buyfactor.product_qty,buyfactor.factor_fi,products.product_name from buyfactor,products where buyfactor.product_id=? and buyfactor.product_id=products.product_id order by buyfactor.buy_date ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $buys = $stmt->fetchAll();
        $sql = "SELECT sellfactors.sellfactor_id,sellfactors.credit_after_sell,sellfactors.sell_date,sellfactors.product_qty,sellfactors.factor_fi,products.product_name from sellfactors,products where sellfactors.product_id=? and sellfactors.product_id=products.product_id order by sellfactors.sell_date ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $sells = $stmt->fetchAll();
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
        نمایش مشخصات کالای <?= $product->product_name ?>
    </p>
    <table id="detailTable" style=" border: 1px solid">
        <tr style=" border: 1px solid">
            <th onclick="sortTable(0)" style=" border: 1px solid">ردیف</th>
            <th onclick="sortTable(1)" style=" border: 1px solid">تاریخ عملیات</th>
            <th onclick="sortTable(1)" style=" border: 1px solid">شماره فاکتور مربوطه </th>
            <th onclick="sortTable(2)" style=" border: 1px solid">تعداد کالا خرید</th>
            <th onclick="sortTable(3)" style=" border: 1px solid">تعداد کالای فروش</th>
            <th onclick="sortTable(4)" style=" border: 1px solid">مانده</th>
        </tr>
        <?php $i = 1;
foreach ($buys as $buy) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d", $buy->buy_date) ?> </td>
            <td style=" border: 1px solid"><a href="./buyfactorpre.php?id=<?= $buy->buyfactor_id ?>">فاکتور خرید شماره
                    <?= $buy->buyfactor_id ?></a></td>
            <td style=" border: 1px solid"><?= $buy->product_qty ?></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= $buy->credit_prod_after ?></td>
        </tr>
        <?php  ++$i;
} ?>
        <?php ;
foreach ($sells as $sell) {?>
        <tr>
            <td style=" border: 1px solid"><?= $i ?></td>
            <td style=" border: 1px solid"><?= jdate("Y/m/d", $sell->sell_date) ?> </td>
            <td style=" border: 1px solid"><a href="./sellfactorpre.php?id=<?= $sell->sellfactor_id ?>">فاکتور فروش
                    شماره <?= $sell->sellfactor_id ?></a></td>
            <td style=" border: 1px solid">0</td>
            <td style=" border: 1px solid"><?= $sell->product_qty ?></td>
            <td style=" border: 1px solid"><?= $sell->credit_after_sell ?></td>
        </tr>
        <?php ++$i;
} ?>
    </table>
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
            <a href="./productlist.php" class="btn btn-light border">
                برگشت به لیست کالاها
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