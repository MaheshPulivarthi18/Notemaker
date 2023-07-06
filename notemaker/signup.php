<?php
 ini_set('session.gc_maxlifetime', 18);

 session_start();
 // Check if the session has expired
 if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] > ini_get('session.gc_maxlifetime')) {
     // Session expired, destroy it and perform logout actions
     session_unset();
     session_destroy();
     // Redirect or perform additional actions as needed
     header("Location: logout.php");
    exit;
 }

// Update the last activity time
 $_SESSION['LAST_ACTIVITY'] = time();
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconn.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    // $exists=false;

    // Check whether this username exists
    $existSql = "SELECT * FROM `users` WHERE username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if ($numExistRows > 0) {
        // $exists = true;
        $showError = "Username Already Exists";
    } else {
        // $exists = false; 
        if (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` ( `username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
    if ($showAlert == true && $showError == false) {
        $sql = "CREATE TABLE `notesmaker`.`$username` (`sno` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(11) NOT NULL , `description` TEXT NOT NULL , `tstamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`sno`))";
        $res = mysqli_query($conn, $sql);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href="blogicon1.png">
    <title>SignUp
    </title>
    <style>
    body {
        background-image: url('bg-img1.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
    </style>
</head>

<body class="bg-img"><?php require 'nav.php' ?><?php if ($showAlert) {
                                                    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success !</strong>Your account is now created and you can login <button type="button"class="close"data-dismiss="alert"aria-label="Close"><span aria-hidden="true">&times;
        </span></button></div>';
                                                }

                                                if ($showError) {
                                                    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>Error !</strong>' . $showError . '
        <button type="button"class="close"data-dismiss="alert"aria-label="Close"><span aria-hidden="true">&times;
        </span></button></div>';
                                                }

                                                ?><div class="container my-4" style="max-width: 500px; background-image: url('bg-img1.jpg');background-size: cover;
        background-repeat: no-repeat;
        background-position: center center; padding:50px;border-radius:13px; color:black;">
        <h1 class="text-center">
            <h1 class="text-center">Signup to note</h1>
            <form action="/notemaker/signup.php" method="post">
                <div class="form-group" style="color: white;"><label for="username">Username</label><input type="text"
                        maxlength="11" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                </div>
                <div class="form-group" style="color: white;"><label for="password">Password</label><input
                        type="password" maxlength="23" class="form-control" id="password" name="password"></div>
                <div class="form-group" style="color: white;"><label for="cpassword">Confirm Password</label><input
                        type="password" class="form-control" id="cpassword" name="cpassword"><small id="emailHelp"
                        class="form-text text-light">Make sure to type the same password</small></div><button
                    type="submit" class="btn btn-outline-success">SignUp</button>
            </form>
    </div>
    <footer>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color:azure;">
            <p>
                We have made this small and tidy website to note ur dialy day routines and to have a note of our special
                memories in life
                <br>
                life is short every day is valued and every memory is precious don,t forget to note it!!!!
            </p>
            © 2023 mahesh:
            <a class="text-light" href="https://www.instagram.com/mahesh.pulivarthi.92/"
                target="_blank">MaheshPulivarthi</a>
        </div>
        <!-- Copyright -->
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>