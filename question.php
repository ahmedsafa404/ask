<?php
require_once ("lib/header.php");
require_once ("vendor/autoload.php");
use Askme\Askme\Askme;



if(isset($_GET['id']))
{


    $id = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($_GET['id']))));

    $question = new Askme();
    $ask = $question->Question($id);


}

    $userID = $_SESSION['user']['id'];

    $answer = new Askme();
    $getAnswer = $answer->getAnswer($id);

    $question_answer_count = new Askme();
    $question_answer_count = $question_answer_count->question_answer_count($id);

    $most_view_question = new Askme();
    $most_view_question->most_viewed_Question($id);

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

        <li class="list-group-item">
            <a href="index.php">Back to Home</a>
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <font color="#f0f8ff" size="4"><strong><?php echo $ask['question'];?></strong></font></div>
                <div class="panel-body">
                    <p>
                        <strong>Posted at : <?php echo $ask['created_at'];?></strong>
                    </p>
                    <p><?php echo $ask['description'];?></p>
                </div>
            </div>

            <?php

            if(isset($_SESSION['user']))
            { ?>

                <form method="post">
                    <div class="form-group">
                        <span class="glyphicon glyphicon-comment"></span> <label for="answer"><font size="4" color="#a52a2a">Answer this question</font></label>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" cols="50" id="answer" name="answer" placeholder="Write a answer"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" id="submit-answer" style="float: right">Post Your Answer</button>
                    <input type="hidden" id="questionID" value="<?php echo $ask['id'];?>">
                    <input type="hidden" id="userID" value="<?php echo $_SESSION['user']['id'];?>">
                </form>
            <?php }?>
                <hr>

        <font color="#d2691e" size="4" style="text-align: left">Answers</font>
            <p style="text-align: right"> <?php echo $question_answer_count['Answer_count'];?> Answers</p>
                <hr>





                <?php
                    foreach ($getAnswer as $answer => $value)
                    {


                ?>
                <div class="panel panel-primary">
                    <div class="panel-body">





                        <h5><strong><img src=/askme/view/admin/<?php echo $value['profile_pic'];?> height="50" class="img-circle" width="50">
                                <?php  echo $value['firstname']." ".$value['lastname'];?></strong></h5>

                        <p><?php echo $value['answer'];?></p>
                    </div>
                </div>
                <?php }?>



        </li>

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

</div>

</div>
<script>
    $("#submit-answer").click(function()
    {
        var answer = $("#answer").val();
        var questionID = $("#questionID").val();
        var userID = $("#userID").val();

        if(answer == '')
        {
            alert('Please write an answer first.');
            return;
        }

        $.ajax({
            url : "view/admin/answer.php",
            method : "POST",
            async : false,
            data : {
                "post" : 1,
                "answer" : answer,
                "questionID" : questionID,
                "userID" : userID
            },

            success:function(data)
            {
                alert(data);
                $("#answer").val('');
            }
        });

    });
</script>


<?php require_once('lib/footer.php') ?>












