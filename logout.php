<?php
require "./newffff/Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
if (isset($_SESSION['username'])) {
    session_destroy();
}
header("location:login.php");
