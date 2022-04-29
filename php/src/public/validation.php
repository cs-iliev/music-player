<?php 

session_start();

$con = mysqli_connect('db', 'root', 'MYSQL_ROOT_PASSWORD');

mysqli_select_db($con, 'MYSQL_DATABASE');

$name = $_POST['user'];
$password = hash("sha256", $_POST['password']);

$s = " select * from user_table where name = '$name' && password = '$password'";

$result = mysqli_query($con, $s);

$num = mysqli_num_rows($result);

if ($num == 1) {
    header('location:musicPlayer.php');
}else{
    header('location:index.php');
}

?>