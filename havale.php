<?php
require "./newffff/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./newffff/Helper/helpers.php";
global $db;
$errors = [];
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}
$sql = "SELECT * FROM personaccount where (account_type='1' or account_type='3')";
$stmt = $db->prepare($sql);
$stmt->execute([]);
$customers = $stmt->fetchAll();
if (isset($_POST['submit'])) {
    date_default_timezone_set('Iran');
    $realTimestamp = substr($_POST['havale_date'], 0, 10);
    $bestankar = $_POST['bestankar'];
    $bedehkar = $_POST['bedehkar'];
    $havale_fi = $_POST['havale_fi'];
    $havale_explanation = $_POST['havale_explanation'];
    if (!($bestankar == $bedehkar)) {
        $tok = 1;
        $sql = "INSERT INTO transfer SET transfersend_date=?,transfersend_from=?,transfersend_to=?,transfersend_price=?,useredit_id=?,transfersend_explanation=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$realTimestamp,$bestankar,$bedehkar,$havale_fi,$_SESSION['user_id'],$havale_explanation]);
        $id = $db->lastInsertId();
        $sql = "SELECT * FROM personaccount WHERE cust_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bestankar]);
        $bestan= $stmt->fetch();
        $ttl_bestan_old = $bestan->total_credit;
        if($ttl_bestan_old < 0) {
            $ttl_bestan_new = $ttl_bestan_old + $havale_fi;
        } else {
            $ttl_bestan_new = $ttl_bestan_old - $havale_fi;

        }
        $sql = "INSERT INTO credits SET personaccount_id=?,credit=?,transfer_id=?,credit_after=?,edit_user=?,created_at =?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bestankar,$havale_fi,$id,$ttl_bestan_new,$_SESSION['user_id'],$realTimestamp]);
        $id1 = $db->lastInsertId();



        $sql = "SELECT * FROM personaccount WHERE cust_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bedehkar]);
        $bedeh= $stmt->fetch();
        $ttl_bedeh_old = $bedeh->total_credit;
        if($ttl_bedeh_old < 0) {
            $ttl_bedeh_new = $ttl_bedeh_old + $havale_fi;
        } else {
            $ttl_bedeh_new = $ttl_bedeh_old - $havale_fi;

        }
        $sql = "INSERT INTO credits SET personaccount_id=?,credit=?,transfer_id=?,credit_after=?,edit_user=?,created_at =?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bedehkar,-$havale_fi,$id,$ttl_bedeh_new,$_SESSION['user_id'],$realTimestamp]);
        $id2 = $db->lastInsertId();


        $sql = "SELECT * FROM personaccount WHERE cust_id=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bestankar]);
        $res1 = $stmt->fetch();
        $total_bestan_old = $res1->total_credit;
        if($total_bestan_old < 0) {
            $total_bestan_new = $total_bestan_old + $havale_fi;
        } else {
            $total_bestan_new = $total_bestan_old - $havale_fi;

        }        $sql = "UPDATE personaccount SET total_credit=? WHERE cust_id=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$total_bestan_new,$bestankar]);


        $sql = "SELECT * FROM personaccount WHERE cust_id=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bedehkar]);
        $res2 = $stmt->fetch();
        $total_bedeh_old = $res2->total_credit;
        if($total_bedeh_old < 0) {
            $total_bedeh_new = $total_bedeh_old + $havale_fi;
        } else {
            $total_bedeh_new = $total_bedeh_old - $havale_fi;

        }        $sql = "UPDATE personaccount SET total_credit=? WHERE cust_id=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$total_bedeh_new,$bedehkar]);


        $bedehkar_name = $res2->cust_name;
        $bestankar_name = $res1->cust_name;

    } else {
        $errors[] = "هر دو شخص نمیتواند یکی باشد";
        $tok = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>havale</title>
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
    <div class="heading" style="background:url(./newffff/CSS/purchase2.png) no-repeat">
        <h1> حواله </h1>
    </div>
    <section class="bg-light my-0 px-2">
        <?php if (isset($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
        <small class="text-danger"><?= $error . '<br>' ?></small>
        <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- purchasing section starts -->

    <section class="booking">
        <h1 class="heading-title"></h1>
        <form action="" method="POST" class="book-form">
            <div class="flex">
                <div class="inputBox">
                    <span> طرف حساب بستانکار : </span>
                    <select name="bestankar" class="inputBox">
                        <option>لطفا یکی از تامین کنندگان زیر را انتخاب فرمایید</option>
                        <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer->cust_id ?>" class="inputBox"><?= $customer->cust_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="inputBox">
                    <span> طرف حساب بدهکار : </span>
                    <select name="bedehkar" class="inputBox">
                        <option>لطفا یکی از تامین کنندگان زیر را انتخاب فرمایید</option>
                        <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer->cust_id ?>" class="inputBox"><?= $customer->cust_name ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="inputBox">
                    <span>تاریخ حواله :</span>
                    <input type="text" class="form-control d-none" id="havale_date" name="havale_date" required
                        autofocus>
                    <input type="text" class="form-control" id="havale_view" required autofocus>
                </div>
                <div class="inputBox">
                    <span>مبلغ حواله: </span>
                    <input type="text" placeholder="مبلغ حواله" name="havale_fi">
                </div>
                <div class="inputBox">
                    <span> توضیحات حواله:</span>
                    <textarea name="havale_explanation" rows="5" cols="45"></textarea>
                </div>


            </div>

            <input type="submit" value="ثبت حواله" class="btn" name="submit" id="submit">


            <?php
            if (isset($_POST['submit']) && $stmt->rowCount() == 1 && $tok==1) {
                echo "
        <script>
        setTimeout(function() {
            swal('حواله شماره {$id} ثبت شد','حواله شماره {$id1} برای {$bestankar_name} و حواله شماره {$id2} برای {$bedehkar_name} ثبت شد', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./havaleview.php?id={$id}');
        }, 5000);
        </script>
        ";
            }
?>
        </form>
    </section>

    <script src="./newffff/JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./newffff/JS/bootstrap.min.js"></script>
    <script src="./newffff/Public/jalalidatepicker/persian-date.min.js"></script>
    <script src="./newffff/Public/jalalidatepicker/persian-datepicker.min.js"></script>
    <script src='./newffff/JS/sweet-alert.min.js'></script>
    <script>
    $(document).ready(function() {
        $("#havale_view").persianDatepicker({
            format: 'YYYY-MM-DD',
            toolbax: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '#havale_date'
        })
    });
    </script>


</body>

</html>