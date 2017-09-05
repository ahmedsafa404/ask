<?php
session_start();

if(empty($_SESSION['user'])){
    header('location:../../index.php');
    exit();
}

require_once ("../../vendor/autoload.php");

use Askme\Askme\Askme;


if ($_POST['answer'])
{
    $userID = $_SESSION['user']['id'];

    $answer     = $_POST['answer'];
    $questionID = $_POST['questionID'];
    $userID     = $_POST['userID'];

    if(empty($answer))
    {
        echo "Write an answer";
    }

    $postAnswer = new Askme();
    $postAnswer->Answer($_POST);

    $point_for_answer = new Askme();
    $point_for_answer->point_for_answer($userID);

}

