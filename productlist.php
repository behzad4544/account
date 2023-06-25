<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
global $db;
// $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty,buyfactor.factor_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.  "
$sql = "SELECT products.product_name,products.product_id,wearhouses.wearhouse_name,stocks.stock from products,wearhouses,stocks WHERE stocks.stock_productid = products.product_id and stocks.stock_wearhouseid = wearhouses.wearhouse_id ";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

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
    <table id="myTable2" style="border: 1px solid">
        <tr>
            <th onclick="sortTable(0)" style=" border: 1px solid">ردیف</th>
            <th onclick="sortTable(1)" style=" border: 1px solid">نام کالا</th>
            <th onclick="sortTable(2)" style=" border: 1px solid">موجودی کالا</th>
            <th onclick="sortTable(3)" style=" border: 1px solid">نام انبار</th>
        </tr>
        <?php $i = 1;
foreach ($products as $product) {?>
        <tr>
            <td style=" border: 1px solid"><a href="./productdetail.php?id=<?= $product->product_id ?>"><?= $i ?></a>
            </td>
            <td style=" border: 1px solid"><a
                    href="./productdetail.php?id=<?= $product->product_id ?>"><?= $product->product_name ?></a></td>
            <td style=" border: 1px solid"><a
                    href="./productdetail.php?id=<?= $product->product_id ?>"><?= $product->stock ?></a></td>
            <td style=" border: 1px solid"><a
                    href="./productdetail.php?id=<?= $product->product_id ?>"><?= $product->wearhouse_name ?></a></td>
        </tr>
        <?php ++$i;
} ?>
    </table>
    <script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable2");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
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