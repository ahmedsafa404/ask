<?php

require_once ("../../vendor/autoload.php");

use Askme\Askme\Askme;

$picture = new Askme();
$picture->upload($_POST);