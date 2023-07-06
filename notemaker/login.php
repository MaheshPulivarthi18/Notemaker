<?php
ini_set('session.gc_maxlifetime', 18);
// Start or resume the session
session_start();
// Set session timeout to 30 minutes


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

$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconn.php';
    $username = $_POST["username"];
    $password = $_POST["password"];


    // $sql = "Select * from users where username='$username' AND password='$password'";
    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            } else {
                $showError = "Invalid Credentials";
            }
        }
    } else {
        $showError = "Invalid Credentials";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="blogicon1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Login</title>
    <style>
    body {
        background-image: url('bg-img14.webp');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
    </style>
</head>

<body>
    <?php require 'nav.php' ?>
    <?php
    if ($login) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }
    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }
    ?>

    <div class="container my-4" style="max-width: 500px; background-image: url('bg-img2.jpg');background-size: cover;
        background-repeat: no-repeat;
        background-position: center center; padding:40px;border-radius:13px; color:black;">
        <h1 class="text-center">Login to note</h1>
        <form action="/notemaker/login.php" method="post">
            <div class="form-group" style="color:whitesmoke;">
                <label for=" username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">

            </div>
            <div class="form-group" style="color:whitesmoke;">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>


            <button type="submit" class="btn btn-success">Login</button>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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