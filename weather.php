<?php
session_start();
include('connect.php');
$api_key = "dd06be124cff689ed052b9a083845671";
$city_name = $_GET['city'];
$get_current_weather = "http://api.openweathermap.org/data/2.5/weather?q=" . $city_name . ",&appid=" . $api_key . "&units=metric";
$get_5day3hour_weather = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city_name . ",&appid=" . $api_key . "&units=metric";

$content_current_weather = file_get_contents($get_current_weather);
$content_5day3hour_weather = file_get_contents($get_5day3hour_weather);

$result_current_weather = json_decode($content_current_weather);
$result_5day3hour_weather = json_decode($content_5day3hour_weather);

$search_history = mysqli_query($link, "select * from search_history_" . $_SESSION['username']);
if (mysqli_num_rows($search_history) == 0) {
    $sql_create = "create table search_history_" . $_SESSION['username'] . "(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            City VARCHAR(50) NOT NULL,
            Date VARCHAR(50) NOT NULL,
            Temperature VARCHAR(50) NOT NULL,
            FeelsLike VARCHAR(50) NOT NULL,
            Humidity VARCHAR(50) NOT NULL,
            Description VARCHAR(50) NOT NULL,
            Wind VARCHAR(50) NOT NULL
            )";
    mysqli_query($link, $sql_create);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="index_style.css">
</head>

<body>
    <section>
        <div class="current-weather">
            <p>The weather in <?php echo $_GET['city']; ?> is currently '<?php echo $result_current_weather->weather[0]->description; ?>'.<br></p>
            <p>The temperature is <?php echo $result_current_weather->main->temp; ?>°C.<br></p>
            <p>Humidity <?php echo $result_current_weather->main->humidity; ?>.<br></p>
            <p>Wind speed <?php echo $result_current_weather->wind->speed; ?> mph.<br></p>
        </div>
    </section>


    <?php
    for ($i = 0; $i < 5; $i++) {
        $icon = $result_5day3hour_weather->list[$i * 8 + 5]->weather[0]->icon;

        $city = $_GET['city'];
        $date = substr($result_5day3hour_weather->list[$i * 8]->dt_txt, 0, 10);
        $temp = $result_5day3hour_weather->list[$i * 8]->main->temp;
        $feels_like = $result_5day3hour_weather->list[$i * 8]->main->feels_like;
        $humidity = $result_5day3hour_weather->list[$i * 8]->main->humidity;
        $description = $result_5day3hour_weather->list[$i * 8]->weather[0]->description;
        $wind = $result_5day3hour_weather->list[$i * 8]->wind->speed;

        $sql = "insert into search_history_" . $_SESSION['username'] . " (City,Date,Temperature,FeelsLike,Humidity,Description,Wind) 
    values ('$city', '$date', '$temp', '$feels_like', '$humidity', '$description', '$wind')";
        mysqli_query($link, $sql);
    }
    $result = mysqli_query($link, "select * from icons where name = '$icon'");
    $row = mysqli_fetch_array($result);
    ?>


    <div class="message">
        <h1> The Weather Forecast </h1>
    </div>

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
                <tr>
                    <th scope="row"><?php echo '<img src="data:images;base64,' . base64_encode($row['image']) . '" width="25px">' ?></th>
                    <td><?php echo $_GET['city']; ?></td>
                    <td><?php echo substr($result_5day3hour_weather->list[0]->dt_txt, 0, 10); ?></td>
                    <td><?php echo $result_5day3hour_weather->list[0]->main->temp; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[0]->main->feels_like; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[0]->main->humidity; ?>.</td>
                    <td><?php echo $result_5day3hour_weather->list[0]->weather[0]->description; ?></td>
                    <td><?php echo $result_5day3hour_weather->list[0]->wind->speed; ?>m/s</td>
                </tr>
                <tr>
                    <th scope="row"><?php echo '<img src="data:images;base64,' . base64_encode($row['image']) . '" width="25px">' ?></th>
                    <td><?php echo $_GET['city']; ?></td>
                    <td><?php echo substr($result_5day3hour_weather->list[8]->dt_txt, 0, 10); ?></td>
                    <td><?php echo $result_5day3hour_weather->list[8]->main->temp; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[8]->main->feels_like; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[8]->main->humidity; ?>.</td>
                    <td><?php echo $result_5day3hour_weather->list[8]->weather[0]->description; ?></td>
                    <td><?php echo $result_5day3hour_weather->list[8]->wind->speed; ?>m/s</td>
                </tr>
                <tr>
                    <th scope="row"><?php echo '<img src="data:images;base64,' . base64_encode($row['image']) . '" width="25px">' ?></th>
                    <td><?php echo $_GET['city']; ?></td>
                    <td><?php echo substr($result_5day3hour_weather->list[16]->dt_txt, 0, 10); ?></td>
                    <td><?php echo $result_5day3hour_weather->list[16]->main->temp; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[16]->main->feels_like; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[16]->main->humidity; ?>.</td>
                    <td><?php echo $result_5day3hour_weather->list[16]->weather[0]->description; ?></td>
                    <td><?php echo $result_5day3hour_weather->list[16]->wind->speed; ?>m/s</td>
                </tr>
                <tr>
                    <th scope="row"><?php echo '<img src="data:images;base64,' . base64_encode($row['image']) . '" width="25px">' ?></th>
                    <td><?php echo $_GET['city']; ?></td>
                    <td><?php echo substr($result_5day3hour_weather->list[24]->dt_txt, 0, 10); ?></td>
                    <td><?php echo $result_5day3hour_weather->list[24]->main->temp; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[24]->main->feels_like; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[24]->main->humidity; ?>.</td>
                    <td><?php echo $result_5day3hour_weather->list[24]->weather[0]->description; ?></td>
                    <td><?php echo $result_5day3hour_weather->list[24]->wind->speed; ?>m/s</td>
                </tr>
                <tr>
                    <th scope="row"><?php echo '<img src="data:images;base64,' . base64_encode($row['image']) . '" width="25px">' ?></th>
                    <td><?php echo $_GET['city']; ?></td>
                    <td><?php echo substr($result_5day3hour_weather->list[32]->dt_txt, 0, 10); ?></td>
                    <td><?php echo $result_5day3hour_weather->list[32]->main->temp; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[32]->main->feels_like; ?>°C</td>
                    <td><?php echo $result_5day3hour_weather->list[32]->main->humidity; ?>.</td>
                    <td><?php echo $result_5day3hour_weather->list[32]->weather[0]->description; ?></td>
                    <td><?php echo $result_5day3hour_weather->list[32]->wind->speed; ?>m/s</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>