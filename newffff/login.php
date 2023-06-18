<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- CSS File -->
    <link rel="stylesheet" href="./CSS/style.css">

</head>
<body class="bg-gradiant-green-blue">
    <div class="login">
        <h1 class="text-center"> سامانه حسابداری </h1>

        <form class="needs-validation">
            <div class="form-group was-validated">
                <label class="form-label" for="username"> نام کاربری </label>
                <input class="form-control" type="text" id="username" required>
                <div class="invalid-feedback">
                    لطفا نام کاربری خود را وارد کنید
                </div>
            </div>

            <div class="form-group was-validated">
                <label class="form-label" for="password"> کلمه عبور </label>
                <input class="form-control" type="password" id="password" required>
                <div class="invalid-feedback">
                    لطفا کلمه عبور خود را وارد کنید
                </div>
            </div>
            
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" id="check">
                <label class="form-check-label" for="check">Remember me</label>
            </div>

            <input class="btn btn-success w-100" type="submit" value="Login">

        </form>


    </div>
    
</body>
</html>