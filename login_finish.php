<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>www_hw3</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <?php
        //connect to the database
        include('connect.php');

        $username = "";

        //if the login button is clicked
        if(isset($_POST['login-submit'])){

            $username = $_POST['username'];
            $password = $_POST['password'];
            $errors = array();


            //ensure that form fields are filled properly
            if(empty($username)||empty($password)){
                array_push($errors,"empty fields error.");
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
            //login success
            if(count($errors)==0){
                $password = md5($password);
                $user = mysqli_query($link,"select * from registration where username='$username' && password='$password'");
                if(mysqli_num_rows($user)==1){
                    //log user in
                    $_SESSION['username'] = $username;
                    header('location:index.php');
                }
                //login failed
                else {
                    array_push($errors,"Wrong username/password combination.");
                    array_push($errors,"empty fields error.");
                    echo '
                        <script type="text/javascript">

                        $(document).ready(function login_failed() {

                            Swal.fire({
                                icon: "error",
                                title: "Login failed!",
                                text: "Incorrect username or password.",
                                showConfirmButton: true,
                            }).then(function () {
                                window.location.href = "first.php";
                            });
                        });

                        </script>
                    ';
                }
            }
        }
    ?>
</body>