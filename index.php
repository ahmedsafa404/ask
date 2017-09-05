<?php
require_once('lib/header.php');
include_once ("vendor/autoload.php");

use Askme\Askme\Askme;

$Question = new Askme();
$allQuestion = $Question->questions();

$question = new Askme();
$question_count = $question->Question_count();

$answer = new Askme();
$answer_count = $answer->Answer_count();

$user = new Askme();
$user_count =$user->User_count();

$most_viewed_question = new Askme();
$most_viewed_question = $most_viewed_question->get_most_viewed_Question();



?>

<div class="container">
    <div class="col-md-8">


        <?php
        if(isset($_SESSION['user']))
        {


            ?>

            <li><a href="view/admin/question.php?username=<?php echo htmlspecialchars(htmlentities(stripslashes(strip_tags($_SESSION['user']['username'])))); ?>"> <span class="glyphicon glyphicon-pencil"></span>Ask Question</a></li>

        <?php } ?>


        <ul class="list-group">


            <?php

            foreach($allQuestion as $question => $item)
            { ?>
            <li class="list-group-item">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a href=question.php?id=<?php echo $item['id'];?>><font color="#f0f8ff" size="4"><strong><?php echo $item['question'];?></strong></font></a>

                        </div>
                    <div class="panel-body">
                        <p>
                            <strong>Posted at : <?php echo $item['created_at'];?></strong>
                        </p>

                        <p>
                            <?php  $length = strlen($item['description']);
                                    echo substr($item['description'],0,$length/2);
                            ?>
                            ...
                            <br/><a href=question.php?id=<?php echo htmlspecialchars(htmlentities(stripslashes(strip_tags($item['id']))));?>>See More</a>
                        </p>
                    </div>
                </div>
            </li>
            <?php }?>




        </ul>
        <nav aria-label="Page navigation">
            <ul class="pagination pull-right">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    <div class="col-md-4">

        <h2><font color="#d2691e">Most Viewed Question</font></h2>
        <div class="">
            <ul class="list-group">

                <?php
                foreach ($most_viewed_question as $most => $view) { ?>
                    <li class="list-group-item">
                        <div class="">
                            <a href="question.php?id=<?php echo htmlspecialchars(htmlentities(stripslashes(strip_tags($view['id']))));?>"><?php echo $view['question'];?></a>

                        </div>
                    </li>

                    <?php }?>


            </ul>
        </div>


        <h2><font color="green">Website Status</font></h2>
        <hr>
        <div class="count">
            <font color="black" size="2"><strong>Total Question :</strong></font><?php echo $question_count['Question'];?>
            <br>
            <font color="black" size="2"><strong>Total Answer :</strong></font><?php echo $answer_count['Answer'];?>
            <br>
            <font color="black" size="2"><strong>Total User :</strong></font><?php echo $user_count['User'];?>

        </div>


    </div>
</div>


<?php require_once('lib/footer.php') ?>
