<?php
session_start();
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Weather Now</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="index_style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand navbar-color" href="index.php">Weather Page</a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">History</a>
                    </li>
                </ul>
                <span class="navbar-text">Hello, <?php echo $_SESSION['username']; ?> !</span>
            </div>
        </div>
    </nav>
    <section>
        <div class="message">
            <h1>The Weather Now In Your City</h1>
            <p>Enter the name of a city.</p>
            <form method="GET" action="index.php">
                <div class="center">
                    <input type="text" name="city" value="<?php echo $_GET['city']; ?>" placeholder="Eg. NewYork, Tokyo"></br>
                </div>
                <div class="center">
                    <input type="submit" value="Search"></br>
                </div>
            </form>
        </div>
    </section>

    <?php
    if (isset($_GET['city']) && !empty($_GET['city'])) {
        include("weather.php");
    }
    if (empty($_SESSION['username'])) {
        echo '
      <script type="text/javascript">

      $(document).ready(function(){

      Swal.fire({
          icon: "warning",
          title: "Please login!",
          text: "You do not have permission to access.",
          showConfirmButton: true,
          }).then(function () {
              window.location.href = "first.php";
          }); 
      });

      </script>
      ';
        return;
    }
    ?>
</body>

</html>