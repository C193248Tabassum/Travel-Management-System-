<?php

$connection = mysqli_connect('localhost','travel','travel56dfye','book_db');
session_start();

if (isset($_POST['login'])) {
    $em = $_POST['email'];
    $pa = $_POST['password'];

    $Sselection = "SELECT * from signup_infos WHERE email = '$em'";
    $Sq = mysqli_query($connection, $Sselection);


    if ($Sq) {
        $result = mysqli_fetch_assoc($Sq);
        $row = mysqli_num_rows($Sq);

        if ($row) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['mobile'] = $result['mobile'];
            $_SESSION['password'] = $result['password'];
            $_SESSION['fname'] = $result['fname'];
            $_SESSION['lname'] = $result['lname'];

            if (md5($pa) == $result['password']) {
                echo "<script>window.location.href='home.php'</script>";
            } else {
                echo "<script>alert('Error: Wrong Password!')</script>";
                echo "<script>window.location.href='login.html'</script>";
            }
        }
    }

    if (mysqli_num_rows($Sq) == 0) {
        echo "<script>alert('Error: No account with this email exists!')</script>";
        echo "<script>window.location.href='login.html'</script>";
    }
}