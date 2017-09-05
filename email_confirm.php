<?php
require_once ("vendor/autoload.php");

use Askme\Askme\Askme;





$username = htmlspecialchars(htmlentities(stripslashes(strip_tags($_GET['username']))));
$confirm_code = htmlspecialchars(htmlentities(stripslashes(strip_tags($_GET['confirm_code']))));



$connection = new PDO("mysql:host=localhost;dbname=blog","root","");

$check_code = $connection->prepare("SELECT * FROM users WHERE username= ?");
$check_code->bindParam(1,$username);
$check_code->execute();

$getInfo = $check_code->fetch(PDO::FETCH_ASSOC);

$db_code = $getInfo['confirm_code'];



if($confirm_code === $db_code)
{
    $update = $connection->prepare("UPDATE users SET confirmed = ? , confirm_code = ? LIMIT 1");
    $update->bindValue(1,1);
    $update->bindValue(2,0);

    $update->execute();



    echo "Your Email has been verified";
}
else
{
    die("Invalid Details");
}

//$sendCode = new Askme();
//$sendCode->registration();




