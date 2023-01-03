<?php
$connection = mysqli_connect('localhost','travel','travel56dfye','book_db');

//session_start();
//if (!isset($_SESSION['email'])) {
//    echo "<script>window.location.href='login.html'</script>";
//}

$error = array();

if (isset($_POST['Ssignup'])) {
    $fname = ucwords($_POST['fname']);
    $lname = ucwords($_POST['lname']);
    $mo = $_POST['mobile'];
    $em = $_POST['email'];
    $pa = $_POST['password'];
    $cpa = $_POST['cpassword'];
    $mobile='';
    $email='';
    $password = '';

    $pattern_mobile = "/^[\d]+$/";
    $pattern_pass = '/^(?=.*[0-9])(?=.*[A-Z]).{6,}$/';

    $email_check = "SELECT * FROM signup_infos WHERE email = '$em'";
    $q = mysqli_query($connection, $email_check);


    if (mysqli_num_rows($q) > 0) {
        echo $error['email'] = "<script>alert('Error: An account with your email already exists!')</script>";
        echo "<script>window.location.href='signup.html'</script>";
    }else {
        $email = mysqli_real_escape_string($connection, $em);
    }


    if (preg_match($pattern_mobile, $mo)) {
        $mobile = mysqli_real_escape_string($connection, $mo);
        $_SESSION['mobile_no'] = $mobile;
    } else {
        echo $error['mobile'] = "<script>alert('Error: Mobile number have to be number only!')</script>";
        echo "<script>window.location.href='signup.html'</script>";
    }

    if (preg_match($pattern_pass, $pa)) {
        if ($pa != $cpa) {
            echo $error['cpass'] = "<script>alert('Error: Password does not match with confirm password!')</script>";
            echo "<script>window.location.href='signup.html'</script>";
        } else {
            $password = md5(mysqli_real_escape_string($connection, $pa));
        }
    } else {
        echo $error['pass'] = "<script>alert('Error: Password have to be minimum 6 characters long with at least a uppercase, a lowercase and a number)! ')</script>";
        echo "<script>window.location.href='signup.html'</script>";
    }

    if (isset($_POST['Ssignup'])) {
        if (count($error) == 0) {
            $insertion = "INSERT INTO signup_infos(fname, lname, mobile, email, password) VALUES ('$fname', '$lname', '$mobile', '$email', '$password')";
            $insert_query = mysqli_query($connection, $insertion);

            if ($insert_query) {
                echo "<script>window.location.href='login.html'</script>";
            } else {
                echo "<script>alert('An Error Happened! Please try again.')</script>";
            }
        }
    }

}