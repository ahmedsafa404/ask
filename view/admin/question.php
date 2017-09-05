<?php  session_start();

if(empty($_SESSION['user']))
{
    header('location:../../index.php');
    exit();
}

require_once ("../../vendor/autoload.php");
use Askme\Askme\Askme;

$userID = $_SESSION['user']['id'];

$userInfo = new Askme();
$info = $userInfo->userInfo($userID);


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
            <a class="navbar-brand" href="index.php">Ask++</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="../../index.php"><strong>Go To Home</strong></a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="22" width="26"> <strong> <?php echo strtoupper($_SESSION['user']['firstname']." ".$_SESSION['user']['lastname']);?></strong> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="22" width="26"> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
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

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname']."'s";?>
                        <small>Profile</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Questions
                        </li>
                    </ol>
                </div>
            </div>

            <div class="col-md-8">
                <h4><font color="green">Add Question</font></h4>
            <form method="post" action="add_question.php">
                <div class="form-group">
                    <label for="title">Question Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Question Title" required>

                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" rows="8" cols="60" id="description" class="form-control" placeholder="Write in detail about your question" required></textarea>
                </div>

                <button type="submit" id="question" class="btn btn-success">Submit Question</button>
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user']['id'];?>">
            </form>
            </div>




        </div>
    </div>


</div>


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
