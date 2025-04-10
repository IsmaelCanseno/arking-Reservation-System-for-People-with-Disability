<?php
include 'connect.php';

if(isset($_POST['signUp'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $password = md5($password);

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
        exit();
    }

    // Check if username already exists
    $checkUname = "SELECT * FROM users WHERE uname = '$uname'";
    $result = $conn->query($checkUname);
    if($result->num_rows > 0){
        echo "Username Already Exists!";
        exit();
    }
    

    // Insert new user
    $insertQuery = "INSERT INTO users(fname, lname, uname, email, phone, password)
                    VALUES ('$fname', '$lname', '$uname', '$email', '$phone', '$password')";
    if($conn->query($insertQuery) === TRUE){
        session_start();
        $_SESSION['email'] = $email;
        header("Location: Home.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    echo $insertQuery;
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: Home.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>