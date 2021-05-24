<?php
session_start();
session_destroy();
unset($_SESSION['username']);
header("refresh:5;url=first.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="index_style.css">
</head>

<body>
    <div class="message">
        <h1>You will be signed out after five seconds.</h1>
        <p>
            <a href="first.php">If you are not successfully logged out, please click here.</a>
        </p>
    </div>
</body>

</html>