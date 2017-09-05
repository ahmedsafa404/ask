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
            <li><a href="../../index.php"><strong>Go To Home</strong></a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="22" width="26">   <strong><?php echo strtoupper($_SESSION['user']['firstname']." ".$_SESSION['user']['lastname']);?></strong> <b class="caret"></b></a>
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

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname']."'s";?>
                        <small>Profile</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-info-circle"></i>  <strong>Welcome <?php echo $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];?></strong>
                    </div>
                </div>
            </div>

            <!--User Profile-->

            <div class="row">
                <div class="col-lg-12">

                    <div class="col-lg-12 " >


                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 " align="center">
                                        <img src="<?php echo $info['profile_pic']; ?>" alt="Profile Picture" class="img-circle" height="200" width="200">
                                        <br>
                                        <a class="cd-upload" href="#" data-toggle="modal" data-target="#upload">Upload Photo</a>
                                    </div>

                                    <div class=" col-md-9 col-lg-9 ">
                                        <table class="table table-user-information">
                                            <tbody>
                                            <tr>
                                                <td>Name:</td>
                                                <td><?php echo $info['firstname']." ".$info['lastname'];?></td>
                                            </tr>

                                            <tr>
                                                <td>Location</td>

                                                <td><?php echo $info['location'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number</td>
                                                <td><?php echo $info['phone'];?></td>
                                            </tr>

                                            </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>

                            <div class="panel-footer">

                                            <span class="pull-right">
                                                <a class="btn btn-sm btn-warning" href="#" data-original-title="Edit this user" data-toggle="modal" data-target="#edit" type="button" ><i class="glyphicon glyphicon-edit"></i></a>

                                            </span>

                                <!--Modal for Edit User-->

                                <div class="modal fade" id="edit" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><b>Update Profile</b></h4>
                                            </div>
                                            <div class="col-md-8">
                                                <form action="edit.php" method="post" id="edit">
                                                    <div class="form-group">
                                                        <label for="firstname">Firstname</label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $info['firstname'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lastname">Lastname</label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $info['lastname'];?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="location">Location</label>
                                                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $info['location'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $info['email'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone">Phone No.</label>
                                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $info['phone'];?>">
                                                    </div>

                                                    <button type="submit" class="btn-success" id="update">Update</button>
                                                    <input type="hidden" name="csrf" value="<?php ?>">
                                                    <input type="hidden" name="userid" value="<?php echo $_SESSION['user']['id'];?>">
                                                </form>
                                            </div>

                                            <div class="modal-footer">

                                            </div>
                                        </div>

                                    </div>
                                </div>





                            </div>

                            <div class="modal fade" id="upload" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><b>Upload Profile Picture</b></h4>
                                        </div>
                                        <div class="col-md-8">
                                            <form action="upload.php" method="post" id="loginForm" enctype="multipart/form-data">

                                                <div class="form-group">
                                                    <label for="image">Select Image</label>
                                                    <input type="file" class="form-control" id="image" name="image"/>
                                                </div>
                                                <button type="submit" class="btn-primary" id="upload">Upload</button>
                                                <input type="hidden" name="userid" value="<?php echo $_SESSION['user']['id'];?>">
                                                <input type="hidden" name="csrf" value="<?php ?>">
                                            </form>
                                        </div>

                                        <div class="modal-footer">

                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
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
