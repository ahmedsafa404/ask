<?php

session_start();

if(empty($_SESSION['user'])){
    header('location:../../index.php');
    exit();
}


require_once ("../../vendor/autoload.php");
use Askme\Askme\Askme;

if($_POST)
{

    $userID = $_SESSION['user']['id'];

    $title       = $_POST['title'];
    $description = $_POST['description'];

    $userId      = $_POST['userid'];

    $update = new Askme();
    $update->add_question($_POST);

    $point_for_question = new Askme();
    $point_for_question->point_for_question($userID);


}


