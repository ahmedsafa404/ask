<?php
require_once ("vendor/autoload.php");
use Askme\Askme\Askme;

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ask Question Get Answer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../askme/assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../../askme/assets/js/bootstrap.min.js"></script>

</head>
<body>


<div class="container-fluid">

    <div class="container">

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand logo" href="index.php">AskMe</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Documentation<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href=" ">Questions</a></li>
                            <li><a href=" ">Jobs</a></li>
                            <li><a href=" ">Documentation</a></li>
                        </ul>
                    </li>



                        <li class="btn-md btn-info"><a href="#">Questions</a></li>



                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left" action="search.php" method="get">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" name="" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>


                    <?php
                        if(!isset($_SESSION['user']))
                        {



                    ?>

                    <li><a class="cd-signin" href="#" data-toggle="modal" data-target="#login">Login</a></li>
                    <li><a class="cd-signup" href="#" data-toggle="modal" data-target="#registration">Signup</a></li>

                    <?php } ?>

                    <!-- Modal for Login-->
                    <div class="modal fade" id="login" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><b>Login</b></h4>
                                </div>
                                <div class="col-md-8">
                                    <form action="login.php" method="post" id="loginForm">

                                        <div class="form-group">
                                            <input type="hidden" name="login_token" value="">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>

                                        </div>
                                        <button type="submit" class="btn-success" id="login">Login</button>

                                    </form>

                                </div>

                                <div class="modal-footer">

                                </div>
                            </div>

                        </div>
                    </div>

                    <!--Modal for Registration-->
                    <div class="modal fade" id="registration" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><b>Registration</b></h4>
                                </div>
                                <div class="col-md-8">
                                    <form id="registration_form" action="registration.php" method="post">

                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Choose username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn-primary" id="signup">Signup</button>
                                        <input type="hidden" name="csrf_token" value="">
                                        <div class="register" style="color: green"></div>
                                    </form>


                                </div>

                                <div class="modal-footer">

                                </div>
                            </div>

                        </div>
                    </div>

                    <?php
                        if(isset($_SESSION['user']))
                        {


                    ?>

                    <li><a href="../../blog/view/admin/index.php?username=<?php echo htmlspecialchars(htmlentities($_SESSION['user']['username'])); ?>"> <span class="glyphicon glyphicon-log-out"></span>Dashboard</a></li>

                    <?php } ?>


                </ul>
            </div>
        </nav>

    </div>

</div>
