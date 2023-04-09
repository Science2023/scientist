<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $phone_number = $_POST["phone_number"];
           $password = $_POST["password"];
            require_once "register-login.php";
            $sql = "SELECT * FROM users WHERE $phone_number = '$phone_number'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>رمز عبور اشتباه است!</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>این شماره در سیستم ثبت نشده است!</div>";
            }
        }
        ?>
      <form action="register-login" method="post" dir="rtl">
        <div class="form-group">
            <input type="number" placeholder="نام کاربری:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="رمز عبور:" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="ورود" name="login" class="btn btn-primary">
        </div>
      </form>
     <div dir="rtl"><p>هنوز ثبت نام نکرده اید؟ <a href="registration.php">از اینجا ثبت نام کنید!</a></p></div>
    </div>
</body>
</html>