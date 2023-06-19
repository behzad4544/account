<?php
require "./newffff/Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
global $db;
if (isset($_SESSION['permition']) && !(empty($_SESSION['permition'])) && isset($_SESSION['username']) && !(empty($_SESSION['username']))) {
    $sql = "SELECT * FROM menus where permition_id = ? order by ordermenu ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['permition']]);
    $menus = $stmt->fetchAll();
} else {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <?php foreach ($menus as $menu) : ?>
            <tr>
                <td><a href="<?= $menu->url ?>"><?= $menu->menu_name ?></a></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td><a href="./logout.php">خروج از سیستم</a></td>
        </tr>
    </table>
</body>

</html>