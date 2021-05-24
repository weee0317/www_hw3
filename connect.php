<?php
$user = '406410054';
$password = '406410054';
$db = '406410054';
$host = 'www2021.csie.io';
$port = 3306;

$link = mysqli_init();
$success = mysqli_real_connect(
	$link,
	$host,
	$user,
	$password,
	$db,
	$port
);

if (!$success) {
	die("Connect Error: " . mysqli_connect_error());
}
