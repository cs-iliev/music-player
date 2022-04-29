<?php 

session_start();

header('location:login.php')

$con = mysqli_connect('db', 'root', 'MYSQL_ROOT_PASSWORD');

mysqli_select_db($con, 'MYSQL_DATABASE');

$name = $_POST['user'];
$password = hash("sha256", $_POST['password']);

$s = " select * from user_table where name = '$name'";

$result = mysqli_query($con, $s);

$num = mysqli_num_rows($result);

if ($num == 1) {
    echo "Username alredy taken";
}else{
    $reg = "Insert into user_table(name, password) values ('$name', '$password')";
    mysqli_query($con, $reg);
    echo "Registration successful";
}

?>