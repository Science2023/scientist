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
    <title>فرم ثبت نام</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $full_Name = $_POST["full_name"];
           $phone_number = $_POST["phone_number"];
           $username = $_POST["username"];
           $password = $_POST["password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($full_Name) OR empty($phone_number) OR empty($username) OR empty($password)) {
            array_push($errors,"همه فیلدها باید تکمیل شود");
           }
         
           if (strlen($username)<6) {
            array_push($errors,"نام کاربری باید حداقل 6 کاراکتر باشد!");
           }
       
           require_once "register-login.php";
           $sql = "SELECT * FROM students WHERE phone_number = '$phone_number'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"این شماره قبلا ثبت شده است!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO students (full_name, phone_number, username, password) VALUES ( ?, ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"siss",$full_Name, $phone_number, $username, $password);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>ثبت نام شما با موفقیت انجام شد!</div>";
            }else{
                die("خطایی رخ داده است!");
            }
           }
          

        }
        ?>
        <form action="registration.php" method="post" dir="rtl">
            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="نام و نام خانوادگی:">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="phone_number" placeholder="شماره موبایل:">
            </div>
            <div class="form-group">
                <input type="username" class="form-control" name="username" placeholder="نام کاربری(انگلیسی):">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder=" رمز عبور:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="ثبت نام" name="submit">
            </div>
        </form>
        <div>
        <div><p>قبلا ثبت نام کرده اید؟ <a href="login.php">از اینجا وارد شوید</a></p></div>
      </div>
    </div>
</body>
</html>