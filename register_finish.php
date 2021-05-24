<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www_hw3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
<?php
//connect to the database
include('connect.php');


$username = "";
$errors = array();

//if the register button is clicked
if (isset($_POST['register-submit'])) {

    $username = $_POST['username'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    $duplicate = mysqli_query($link, "select * from registration where username='$username'");

    //ensure that form fields are filled properly
    if (empty($username) || empty($password_1) || empty($password_2)) {
        array_push($errors, "empty fields error.");
        echo '
                <script type="text/javascript">

                $(document).ready(function(){

                    Swal.fire({
                        icon: "error",
                        title: "Registration errors!",
                        text: "Your username and password cannot be empty.",
                        showConfirmButton: true,
                    }).then(function () {
                        window.location.href = "first.php";
                    }); 
                });

                </script>
            ';
    }
    //ensure that username does not duplicate
    else if (mysqli_num_rows($duplicate) > 0) {
        array_push($errors, "duplicate username error.");
        echo '
                <script type="text/javascript">

                $(document).ready(function(){

                    Swal.fire({
                        icon: "error",
                        title: "Duplicate username!",
                        text: "The username already exists.",
                        showConfirmButton: true,
                    }).then(function () {
                        window.location.href = "first.php";
                    });
                });

                </script>
            ';
    }
    //ensure password and confirm password are same
    else if (strcmp($password_1, $password_2) != 0) {
        array_push($errors, "password and confirm password unmatched error.");
        echo '
                <script type="text/javascript">

                $(document).ready(function(){

                    Swal.fire({
                        icon: "error",
                        title: "Registration errors!",
                        text: "Password and confirm password fields are not matched.",
                        showConfirmButton: true,
                    }).then(function () {
                        window.location.href = "first.php";
                    });
                });

                </script>
            ';
    }
    //insert username and password into database
    if (count($errors) == 0) {
        $password = md5($password_1);
        mysqli_query($link, "insert into registration (username,password) values ('$username','$password')");
        echo '
                <script type="text/javascript">

                $(document).ready(function(){

                    Swal.fire({
                        icon: "success",
                        title: "Registration success!",
                        text: "Your account has been successfully created.",
                        showConfirmButton: true,
                    }).then(function () {
                        window.location.href = "first.php";
                    });
                });

                </script>
            ';
    }
}
?>