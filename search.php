<?php
require_once ("lib/header.php");
require_once ("vendor/autoload.php");
use Askme\Askme\Askme;

if (isset($_GET))
{
    $search = new Askme();
    $search = $search->search($_GET['q']);

    $question = new Askme();
    $question_count = $question->Question_count();

    $answer = new Askme();
    $answer_count = $answer->Answer_count();

    $user = new Askme();
    $user_count =$user->User_count();

    $most_viewed_question = new Askme();
    $most_viewed_question = $most_viewed_question->get_most_viewed_Question();
}

?>
<div class="container">
        <div class="col-md-8">

            <?php
            foreach ($search as $item) {
                ?>

                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a href=question.php?id=<?php echo $item['id'];?>><font color="#f0f8ff" size="4"><strong><?php echo $item['question'];?></strong></font></a>
                            </div>
                            <div class="panel-body">

                                <p>
                                    <?php echo $item['description']?>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>

            <?php } ?>
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

<?php require_once ("lib/footer.php");?>