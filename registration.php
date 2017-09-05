<?php
require_once ("vendor/autoload.php");
use Askme\Askme\Askme;


$message ='';
if($_POST)
{
    //Filter

    $token = $_POST['token'];


    $firstname = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['firstName']))));
    $lastname  = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['lastName']))));
    $username  = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['username']))));
    $email     = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['email']))));
    $password  = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['password']))));



   if($firstname == "" or $lastname == "" or $username == "" or $email == "" or $password == "")
    {
        $message =  "<label>All fields are required</label>";
    }
    elseif (!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $message =  "<label>Invalid email format</label>";
    }

    if (Askme::Token() === $token)
    {
        $registrationObject = new Askme();
        $registrationObject->registration($_POST);
    }
    else
    {
        die();
    }



}