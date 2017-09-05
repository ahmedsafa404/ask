<?php
session_start();

if(empty($_SESSION['user'])){
    header('location:../../index.php');
    exit();
}

require_once ("../../vendor/autoload.php");

use Askme\Askme\Askme;


if (isset($_POST))
{

    $userID = $_SESSION['user']['id'];
    $postAnswer = new Askme();
    $postAnswer->Answer($_POST);

    $point_for_answer = new Askme();
    $point_for_answer->point_for_answer($userID);

}

