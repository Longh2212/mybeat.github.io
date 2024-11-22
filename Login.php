<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartBeat Login</title>
    <link rel="stylesheet" href="Login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <?php 
            include("data/connect.php");
            if (isset($_POST['submit'])) {
                $username = mysqli_real_escape_string($con, $_POST['Username']);
                $password = mysqli_real_escape_string($con, $_POST['Password']);

                // Truy vấn kiểm tra tài khoản
                $result = mysqli_query($con, "SELECT * FROM users WHERE Username='$username' AND Password='$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if (is_array($row) && !empty($row)) {
                    // Gán giá trị session khi đăng nhập thành công
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['fullname'] = $row['Fullname'];
                    $_SESSION['id'] = $row['ID'];
                } else {
                    echo "<div class='message'>
                          <p>Wrong Username or Password</p>
                          </div> <br>";
                    echo "<a href='Login.php'><button class='btn'>Go Back</button></a>";
                }

                // Nếu đã đăng nhập thành công, chuyển hướng về trang home
                if (isset($_SESSION['valid'])) {
                    header("Location: index.php");
                    exit(); // Kết thúc script sau khi chuyển hướng
                }
            } else {
            ?>
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="Username" id="Username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="Password" id="Password" placeholder="Password" required>
                <i class='bx bxs-lock'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn" name="submit">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="Register.php">Register</a></p>
            </div>
        </form>
        <?php } ?>
    </div>
</body>
</html>
