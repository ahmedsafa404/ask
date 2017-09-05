<?php  session_start();

if(empty($_SESSION['user'])){
    header('location:../../index.php');
	exit();
}

require_once ("../../vendor/autoload.php");
use Askme\Askme\Askme;



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AskMe</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- User Style -->

    <link rel="stylesheet" type="text/css" href="css/user.css">

</head>

<?php

$userID = $_SESSION['user']['id'];

$userInfo = new Askme();
$info = $userInfo->userInfo($userID);

$askedQuestion = new Askme();
$getAsked_Question = $askedQuestion->user_asked_Question($userID);

$answeredQuestion = new Askme();
$getAnswered_Question = $answeredQuestion->user_answered();


$Question = new Askme();
$myQuestion = $Question->myAskedQuestion($userID);


?>



<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../index.php">Ask++</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li><a href="../../index.php"><strong>Go to Home</strong></a> </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="22" width="26"> <strong><?php echo strtoupper($_SESSION['user']['firstname']." ".$_SESSION['user']['lastname']);?></strong> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="22" width="26"> Profile</a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="../../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php">
                            <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                            My Activity</a>
                    </li>
                    <li class="">
                        <a href="profile.php">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                        User Profile</a>
                    </li>
                    <li class="">
                        <a href="question.php">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Questions</a>
                    </li>


                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

            <div class="col-md-12" style="font-family: "Arial Black", arial-black">
                <font color="#008b8b" size="6"><strong>User Activity</strong></font>
            </div>
            <div class="col-md-12">
                <hr>
            </div>


<!--         User Activity       -->

                <div class="row">

                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-question-circle fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="huge"><?php echo $getAsked_Question['Ask'];?></div>
                                        <div>Total Asked Question!</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="huge"><?php echo $getAnswered_Question['Answer'];?></div>
                                        <div>Total Answered!</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-trophy fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-left">
                                        <div class="huge"><?php echo $info['point'];?></div>
                                        <div>Total Point!</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-12">

                    <div class="col-md-12">
                        <h3><strong>My Asked Question</strong></h3>
                        <hr>
                        <div class="col-md-8">

                            <?php

                            foreach ($myQuestion as $question => $item)
                            { ?>

                                <h4><strong><?php echo $item['question'];?></strong></h4>
                                <p><?php $length = strlen($item['description']); echo substr($item['description'],0,$length/2);?></p>
                                <a href=../../question.php?id=<?php echo htmlspecialchars(htmlentities(stripslashes(strip_tags($item['id']))));?>>See More</a>
                                <hr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
<!--        End User Activity -->

           </div>
        </div>


    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
    <script src="js/user.js"></script>

</body>

</html>
