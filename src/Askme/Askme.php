<?php
namespace Askme\Askme;

use PDO;

class Askme
{
    //Database Migration

    public $dbconnect;
    private $dbserver = "localhost";
    private $dbname = "blog";
    private $dbuser = "root";
    private $dbpass = "";
    //

    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $username;
    private $location;
    private $phone;
    private $userId;
    private $title;
    private $description;
    private $answer;


    public function __construct()
    {
        try {
            $this->dbconnect = new PDO("mysql:host=$this->dbserver;dbname=$this->dbname", "$this->dbuser", "$this->dbpass");

        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }

        return $this->dbconnect;
    }
    /*
    public static function Token()
    {
        #return $_SESSION['login_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        return $login_token = base64_encode(openssl_random_pseudo_bytes(32));
    }

    public static function Verify_Token($token)
    {

        echo Askme::Token();

        die();

        if (isset($_SESSION['login_token']) && $token == $_SESSION['login_token'])
        {
            unset($_SESSION['login_token']);
            return true;
        }
        return false;
    }
    */

    public function login($info = "")
    {

            $this->email = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['email']))));
            $this->password = htmlspecialchars(htmlentities(stripslashes(strip_tags(md5(sha1($info['password']))))));



            $statement = $this->dbconnect->prepare("SELECT * FROM users WHERE email= ? AND password= ? LIMIT 1");

            $statement->bindParam(1,$this->email);
            $statement->bindParam(2,$this->password);
            $statement->execute();



            if($statement->rowCount() == 1 )
            {


                $info = $statement->fetch(PDO::FETCH_ASSOC);

                if($info['confirmed'] == 0 )
                {
                    die("Your account haven't activated.Please check email & activate your account first.");
                }

                session_start();
                $_SESSION['user'] = $info;

                header("location:../../askme/view/admin/index.php");


            }
            else
            {
                $message = "<label>Invalid Email or Password</label>";
            }




    }

    public function registration($info = "")
    {


            $this->firstName = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['firstName']))));
            $this->lastName = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['lasttName']))));
            $this->username = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['username']))));
            $this->email = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['email']))));
            $this->password = htmlspecialchars(htmlentities(stripslashes(strip_tags(md5(sha1($info['password']))))));
            $point = 100;

            //If PHP 7 Exists then it random_bytes will work!

            #$random = random_bytes(10);

            #$confirm_code = bin2hex($random);

            $confirm_code = rand();

            $statement = $this->dbconnect->prepare("INSERT INTO users(firstname,lastname,username,email,password,confirmed,confirm_code,point) VALUES (:firstname,:lastname,:username,:email,:password,:confirmed,:confirm_code,:point)");
            $statement->bindParam(':firstname',$this->firstName);
            $statement->bindParam(':lastname',$this->lastName);
            $statement->bindParam(':username',$this->username);
            $statement->bindParam(':email',$this->email);
            $statement->bindParam(':password',$this->password);
            $statement->bindValue(':confirmed',0);
            $statement->bindParam(':confirm_code',$confirm_code);
            $statement->bindParam(':point',$point);


            //Username Check
            $checkUsernameExist = $this->dbconnect->prepare("SELECT username FROM users WHERE username = ? LIMIT 1");
            $checkUsernameExist->bindParam(1,$this->username);

            $checkUsernameExist->execute();

            //Email Check
            $checkEmailExist = $this->dbconnect->prepare("SELECT email FROM users WHERE email = ? LIMIT 1");
            $checkEmailExist->bindParam(1,$this->email);

            $checkEmailExist->execute();



            if($checkUsernameExist->rowCount()==1)
            {
                $echo = "Username already exists";
                return;
            }
            elseif($checkEmailExist->rowCount()==1)
            {
                echo  "Email already used with another account";
                return;
            }

            $statement->execute();

            $message = "
                    Your Account Activation Code
                    Dear $this->username,
                    Your account activation code is $confirm_code.
                        ";

            mail($this->email,"Account Activation",$message,"From:support@askme.com");


            echo "Registration Complete.Please Activate your email.A code has been sent to your email.";




    }

    public function update($info='')
    {


        $this->firstName = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['firstname']))));
        $this->lastName = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['lastname']))));
        $this->location = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['location']))));
        $this->email = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['email']))));
        $this->phone = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($info['phone']))));
        $this->userId = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($info['userid']))));

        $statement = $this->dbconnect->prepare("UPDATE users SET firstname = ? ,lastname = ? ,location = ? ,email = ? ,phone = ? WHERE id = ? LIMIT 1");
        $statement->bindParam( 1,$this->firstName);
        $statement->bindParam( 2,$this->lastName);
        $statement->bindParam( 3,$this->location);
        $statement->bindParam( 4,$this->email);
        $statement->bindParam( 5,$this->phone);
        $statement->bindParam( 6,$this->userId);

        $statement->execute();

        header("location:index.php");

        $message = "<label>Profile Updated</label>";



    }

    public function upload($info = '')
    {
        $userId    = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($info['userid']))));
        $imageName = htmlspecialchars(htmlentities(stripslashes(strip_tags($_FILES['image']['name']))));
        $imageType = htmlspecialchars(htmlentities(stripslashes(strip_tags($_FILES['image']['type']))));
        $imageSize = htmlspecialchars(htmlentities(stripslashes(strip_tags($_FILES['image']['size']))));
        $imageTmp  = $_FILES['image']['tmp_name'];

        $imageHash = md5($imageName);

        $validext = array('jpg','png','gif','jpeg');
        $ext = strtolower(substr($imageName,strpos($imageName,'.')+1));

        $maxSize = 2097152;

        $path = 'uploads/';

        if(!is_dir($path))
        {
            mkdir($path,"0777",true);
        }
        else
        {
            if(!in_array($ext,$validext))
            {
                exit("Invalid File!");
            }
            elseif (!($imageType == 'image/jpeg' or $imageType == 'image/png' or $imageType == 'image/gif'))
            {
                die("Invalid File Type");
            }
            elseif ($imageSize > $maxSize)
            {
                exit("File size more than 2MB.Please choose less than 2MB.");
            }
            else
            {
                move_uploaded_file($imageTmp,$save = $path.md5($imageName));

                $image = $this->dbconnect->prepare("UPDATE users SET profile_pic = ? WHERE id = ? LIMIT 1");

                $image->bindParam(1,$save);
                $image->bindParam(2,$userId);
                $image->execute();

                header("location:index.php");
            }
        }


    }

    public function userInfo($userID='')
    {
        $userID = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($userID))));

        $data = $this->dbconnect->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $data->bindParam(1,$userID);
        $data->execute();

        $info = $data->fetch(PDO::FETCH_ASSOC);

        return $info;

    }

    public function add_question($info='')
    {

        $this->title = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['title']))));
        $this->description = htmlspecialchars(htmlentities(stripslashes(strip_tags($info['description']))));
        $this->userId = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($info['userid']))));


        $question = $this->dbconnect->prepare("INSERT INTO question(user_id,question,description) VALUES (:user_id,:question,:description)");

        $question->bindParam(':user_id',$this->userId);
        $question->bindParam(':question',$this->title);
        $question->bindParam(':description',$this->description);


        $save = $question->execute();

        if($save == true)
        {
            $message = "<label>Question Added</label>";
            header("location:../../index.php");
        }
        else
        {
            die("Error to save Data");
        }

    }

    public function myAskedQuestion($userId = '')
    {
        $userId = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($userId))));

        $data = $this->dbconnect->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $data->bindParam(1,$_SESSION['user']['id']);
        $data->execute();

        $info = $data->fetch();

        $Question = $this->dbconnect->prepare("SELECT * FROM question WHERE user_id= ? ORDER BY id DESC");
        $Question->bindParam(1,$_SESSION['user']['id']);

        $Question->execute();

        $myQuestion = $Question->fetchAll(PDO::FETCH_ASSOC);

        return $myQuestion;
    }

    public function questions()
    {
        $Question = $this->dbconnect->prepare("SELECT * FROM question ORDER BY id DESC ");
        $Question->execute();

        $getQuestion = $Question->fetchAll(PDO::FETCH_ASSOC);

        return $getQuestion;


    }

    public function User_count()
    {
        $user = $this->dbconnect->prepare("SELECT COUNT(id) AS User FROM users;");
        $user->execute();

        $allUser = $user->fetch(PDO::FETCH_ASSOC);

        return $allUser;


    }


    public function Question_count()
    {
        $question = $this->dbconnect->prepare("SELECT COUNT(id) AS Question FROM question;");
        $question->execute();

        $allQuestion = $question->fetch(PDO::FETCH_ASSOC);

        return $allQuestion;


    }

    public function Answer_count()
    {
        $answer = $this->dbconnect->prepare("SELECT COUNT(id) AS Answer FROM comments;");
        $answer->execute();

        $allAnswer = $answer->fetch(PDO::FETCH_ASSOC);

        return $allAnswer;


    }

    public function most_viewed_Question($question_id='')
    {
        $question_id = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($question_id))));
        $question = $this->dbconnect->prepare("UPDATE question SET viewer=viewer+1 WHERE id= ? ");
        $question->bindParam(1,$question_id);
        $question->execute();

    }

    public function get_most_viewed_Question()
    {
        $check = $this->dbconnect->prepare("SELECT * FROM `question` ORDER BY viewer DESC LIMIT 10");
        $check->execute();

        $get_Questions = $check->fetchAll(PDO::FETCH_ASSOC);

        return $get_Questions;
    }

    public function Question($id='')
    {
        $questionId = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($id))));

        $question = $this->dbconnect->prepare("SELECT * FROM question WHERE id = ? LIMIT 1");
        $question->bindParam(1,$questionId);

        $question->execute();

        $ask = $question->fetch(PDO::FETCH_ASSOC);


        return $ask;
    }

    public function user_asked_Question($userID='')
    {
        $userID = htmlspecialchars(htmlentities(stripslashes(strip_tags($userID))));

        $question = $this->dbconnect->prepare("SELECT COUNT(user_id) AS Ask FROM question WHERE user_id = ?");
        $question->bindParam(1,$userID);

        $question->execute();

        $askedQuestion = $question->fetch(PDO::FETCH_ASSOC);

        return $askedQuestion;
    }

    public function point_for_question($userID='')
    {
        $userID = htmlspecialchars(htmlentities(stripslashes(strip_tags($userID))));

        $point = $this->dbconnect->prepare("UPDATE users SET point = point+10 WHERE id = ? ");
        $point->bindParam(1,$userID);

        $point->execute();

    }

    public function point_for_answer($userID='')
    {
        $userID = htmlspecialchars(htmlentities(stripslashes(strip_tags($userID))));

        $point = $this->dbconnect->prepare("UPDATE users SET point = point+50 WHERE id = ? ");
        $point->bindParam(1,$userID);

        $point->execute();

    }

    public function user_answered($userID='')
    {
        $userID = htmlspecialchars(htmlentities(stripslashes(strip_tags($userID))));

        $answer = $this->dbconnect->prepare("SELECT COUNT(user_id) AS Answer FROM comments WHERE user_id = ?");
        $answer->bindParam(1,$userID);

        $answer->execute();

        $answerQuestion = $answer->fetch(PDO::FETCH_ASSOC);

        return $answerQuestion;
    }

    public function Answer($info='')
    {

        if(isset($_POST['post']))
        {
            $answer = htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['answer']))));
            $questionID = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($_POST['questionID']))));
            $userID = (int)htmlspecialchars(htmlspecialchars(stripslashes(strip_tags($_POST['userID']))));

            $postAnswer = $this->dbconnect->prepare("INSERT INTO comments(question_id,user_id,answer) VALUES (:question_id,:user_id,:answer)");
            $postAnswer->bindParam(':question_id',$questionID);
            $postAnswer->bindParam(':user_id',$userID);
            $postAnswer->bindParam(':answer',$answer);

            $postAnswer->execute();

            echo "Thank you for your answer";
        }


    }

    public function getAnswer($id='')
    {
        $questionID = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($id))));

        $answer = $this->dbconnect->prepare("SELECT users.firstname,users.lastname,users.profile_pic,comments.user_id,comments.answer FROM users,`comments` WHERE question_id = ? AND comments.user_id = users.id ORDER BY comments.id DESC ");
        $answer->bindParam(1,$questionID);

        $answer->execute();

        $getReply = $answer->fetchAll(PDO::FETCH_ASSOC);


        return $getReply;

    }

    public function question_answer_count($questionID='')
    {
        $questionID = (int)htmlspecialchars(htmlentities(stripslashes(strip_tags($questionID))));

        $answerCount = $this->dbconnect->prepare("SELECT COUNT(user_id) AS Answer_count FROM comments WHERE question_id = ?");
        $answerCount->bindParam(1,$questionID);
        $answerCount->execute();

        $answerCount = $answerCount->fetch(PDO::FETCH_ASSOC);

        return $answerCount;
    }

    public function search($question = '')
    {
        $question = htmlspecialchars(htmlentities(stripslashes(strip_tags($question))));
        $search = $this->dbconnect->prepare("SELECT id,question,description FROM question WHERE question OR description LIKE '%?%'");
        $search->bindParam(1,$question);

        $search->execute();

        $search = $search->fetchAll(PDO::FETCH_ASSOC);

        return $search;
    }




}
