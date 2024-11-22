<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartBeat Register</title>
    <link rel="stylesheet" href="Register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function validateForm() {
            var password = document.getElementById("Password").value;
            var email = document.getElementById("Email").value;

            // Kiểm tra độ dài mật khẩu
            if (password.length < 8) {
                alert("Password phải có ít nhất 8 ký tự.");
                return false;
            }

            // Kiểm tra định dạng email
            var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!emailPattern.test(email)) {
                alert("Email phải đúng định dạng.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST" onsubmit="return validateForm()">
            <?php 
                include("data/connect.php");
                if (isset($_POST['submit'])) {
                    $username = $_POST['Username'];
                    $password = $_POST['Password'];
                    $fullname = $_POST['Fullname'];
                    $email = $_POST['Email'];

                    // Kiểm tra điều kiện độ dài mật khẩu
                    if (strlen($password) < 8) {
                        echo "<div class='message'>
                                <p>Password phải có ít nhất 8 ký tự.</p>
                              </div><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                        exit();
                    }

                    // Kiểm tra định dạng email
                    if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                        echo "<div class='message'>
                                <p>Email phải đúng định dạng.</p>
                              </div><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                        exit();
                    }

                    // Kiểm tra xem email đã được sử dụng chưa
                    $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");
                    if (mysqli_num_rows($verify_query) != 0) {
                        echo "<div class='message'>
                                <p>This email is already in use. Try another one.</p>
                              </div><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button></a>";
                    } else {
                        // Thêm dữ liệu vào cơ sở dữ liệu
                        mysqli_query($con, "INSERT INTO users (Username, Password, Fullname, Email) VALUES ('$username', '$password', '$fullname', '$email')") 
                        or die("Error Occurred");

                        echo "<div class='message'>
                                <p>Registration successful!</p>
                              </div><br>";
                        echo "<a href='Login.php'><button class='btn'>Login Now</button></a>";
                    }
                } else {
            ?>
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" name="Username" id="Username" placeholder="Username" autocomplete="off" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="Password" id="Password" placeholder="Password" autocomplete="off" required>
                <i class='bx bxs-lock'></i>
            </div>
            <div class="input-box">
                <input type="text" name="Fullname" id="Fullname" placeholder="Fullname" autocomplete="off" required>
                <i class='bx bxs-credit-card-front'></i>
            </div>
            <div class="input-box">
                <input type="email" name="Email" id="Email" placeholder="Email" autocomplete="off" required>
                <i class='bx bxl-gmail'></i>
            </div>
            <button type="submit" class="btn" name="submit">Submit</button>
            <div class="login-link">
                <p>Already a member? <a href="Login.php">Login now</a></p>
            </div>
        </form>
        <?php } ?>
    </div>
</body>
</html>
