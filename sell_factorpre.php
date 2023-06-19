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
                    <img id="logo" src="./CSS/LOGO.jpg" alt="">
                </div>
                <div class="col-sm-5 text-right">
                    <h4 class="mb-0 text-right"> :فاکتور فروش </h4>

                </div>
            </div>
        </header>
        <main>
            <div class="row">
                <div class="col-sm-6 "><strong> تاریخ:</strong> ۱۴۰۲/۰۲/۳۱ </div>
                <div class="col-sm-6 text-right"><strong>شماره فاکتور:</strong>۱۰۲۲۵</div>
                <div class="col-sm-6 text-left"><strong> نام انبار:</strong>انبار میرداماد</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6 text-right order-sm-1"><strong> :نام ثبت کننده فاکتور</strong>
                    <address>
                        بهزاد کرمانی<br>
                    </address>
                </div>


                <div class="col-sm-6 order-sm-0"><strong>:نام مشتری</strong>
                    <address>
                        زرافشان <br>
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
                                    <td class="col-3 text-center"><strong>1000</strong></td>
                                    <td class="col-3 text-center"><strong>50</strong></td>
                                    <td class="col-3 text-center"><strong>20</strong></td>
                                    <td class="col-3 text-center"><strong>موبایل</strong></td>
                                    <td class="col-3 text-center"><strong>1</strong></td>
                                </tr>

                            </tbody>
                            <tfoot class="card-footer">
                                <tr>
                                    <td class="text-center"><strong>(100)</strong></td>
                                    <td colspan="4" class="text-left"><strong> :مبلغ تخفیف </strong></td>
                                </tr>

                                <tr>
                                    <td class="text-center"><strong> 900 </strong></td>
                                    <td colspan="4" class="text-left"><strong> : مبلغ کل فاکتور </strong></td>

                                </tr>

                                <tr>
                                    <td class="text-center"><strong> 900 </strong></td>
                                    <td colspan="4" class="text-left"><strong> :{زرافشان} مانده </strong></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        </main>
        <footer class="text-right mt-4">
            <p class="text-1"><strong> :توضیحات</strong></p>
            <p class="text-1">بابت فروش موبایل سامسونگ</p>

        </footer>
        <footer class="text-center mt-4">
            <div class="btn-group btn-group-sm ">
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