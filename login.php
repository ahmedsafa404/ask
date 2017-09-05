<?php
require_once ("vendor/autoload.php");
use Askme\Askme\Askme;



if(isset($_POST))
{


    $email = $_POST['email'];
    $password = $_POST['password'];



        if (!empty($email) && !empty($password))
        {
                $loginObject = new Askme();
                $loginObject->login($_POST);


        }



}