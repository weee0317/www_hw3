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
    <title>The Weather History</title>
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
            <h1>The Weather History</h1>
            <form method="GET" action="history.php">
                <div class="center">
                    <input type="text" name="history_city" value="<?php echo $_GET['history_city']; ?>" placeholder="Search the history by city"></br>
                </div>
                <div class="center">
                    <input type="submit" value="Search"></br>
                </div>
            </form>
        </div>
    </section>

    <div class="container panel panel-default table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">City</th>
                    <th scope="col">Date</th>
                    <th scope="col">Temperature</th>
                    <th scope="col">FeelsLike</th>
                    <th scope="col">Humidity</th>
                    <th scope="col">Description</th>
                    <th scope="col">Wind</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!isset($_SESSION['username'])) {
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
                }
                //list the history of one city
                if (isset($_GET['history_city']) && !empty($_GET['history_city'])) {
                    $search = "select * from search_history_" . $_SESSION['username'] . " where City='" . $_GET['history_city'] . "' order by Date DESC";
                    $history = mysqli_query($link, $search);
                }
                //list the history of cities
                else {
                    $search = "select * from search_history_" . $_SESSION['username'] . " order by Date DESC";
                    $history = mysqli_query($link, $search);
                }
                $data_nums = mysqli_num_rows($history);
                $per = 7;
                $pages = ceil($data_nums / $per);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = intval($_GET['page']);
                }
                $start = ($page - 1) * $per;
                $result = mysqli_query($link, $search . ' LIMIT ' . $start . ', ' . $per);
                $num = 1;
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                ?>
                    <tr>
                        <th scope='row'><?php echo $num; ?></th>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td><?php echo $row[3]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td><?php echo $row[5]; ?></td>
                        <td><?php echo $row[6]; ?></td>
                        <td><?php echo $row[7]; ?></td>
                    </tr>
                <?php
                    $num += 1;
                }


                ?>

            </tbody>
        </table>

    </div>
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <?php
            $page = intval($_GET["page"]);
            if ($page <= 1) {
                echo "<a class='page-link' href=?page=1 aria-disabled='true'>Previous</a>";
            } else {
                $page = $page - 1;
                echo "<li class='page-item'><a class='page-link' href=?page=" . $page . ">Previous</a></li>";
            }
            ?>
        </li>
        <?php
        for ($i = 1; $i <= $pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href=?page=" . $i . ">" . $i . "</a></li>";
        }
        ?>
        <li class="page-item">
            <?php
            $page = intval($_GET["page"]);
            if ($page >= $pages) {
                echo "<a class='page-link' href=?page=" . $pages . " aria-disabled='true'>Next</a>";
            } else {
                $page = $page + 1;
                echo "<li class='page-item'><a class='page-link' href=?page=" . $page . ">Next</a></li>";
            }
            ?>
        </li>
    </ul>
</body>

</html>