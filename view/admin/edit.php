<?php
require_once ("../../vendor/autoload.php");
use Askme\Askme\Askme;


if($_POST)
{
    //Filter
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $location  = $_POST['location'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];


    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        echo "Invalid Email";
    }
    elseif (strlen($phone) < 10 )
    {
        echo "Invalid Phone Number";
    }





    $update = new Askme();
    $update->update($_POST);
}