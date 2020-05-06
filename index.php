<?php session_start();?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Hangman</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php
        $MAX_ATTEMPTS = 7;
        $WORDLIST_FILE = 'words.txt';
    ?>
        <?php
            include('functions.php');
            if ( isset($_POST['new_word']) ) unset( $_SESSION['answer'] );
            if (!isset($_SESSION['answer']))
            {
                $_SESSION['attempts'] = 0;
                $answer = fetch_word_array($WORDLIST_FILE);
                $_SESSION['answer'] = $answer;
                $_SESSION['hidden'] = hide_characters($answer);
                echo 'Attempts remaining: '. ($MAX_ATTEMPTS - $_SESSION['attempts']).'<br>';
            }else
            {
                if (isset ($_POST['user_input']))
                {
                    $user_input = $_POST['user_input'];
                    $_SESSION['hidden'] = check_and_replace(strtolower($user_input), $_SESSION['hidden'], $_SESSION['answer']);
                    check_game_over($MAX_ATTEMPTS,$_SESSION['attempts'], $_SESSION['answer'],$_SESSION['hidden']);
                }
                $_SESSION['attempts'] = $_SESSION['attempts'] + 1;
                echo 'Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts'])."<br>";
            }
            $hidden = $_SESSION['hidden'];
            foreach ($hidden as $char) echo $char."  ";
        ?>
            <form name = "input_form" method = "post">
                <label for="">Your Guess: </label> <input name="user_input" type = "text" size="1" maxlength="1" class="btn btn-outline" />
                <input type="submit"  value="Check" onclick="return validateInput()" class="btn btn-primary" />
                <input type="submit" name="new_word" value="Try another Word" class="btn btn-warning" />
            </form>
        </div>
    </div>
</div>

<script type="application/javascript">
    function validateInput()
    {
    var x=document.forms["input_form"]["user_input"].value;
    if (x=="" || x==" ")
      {
          alert("Please enter a character.");
          return false;
      }
    if (!isNaN(x))
    {
        alert("Please enter a character.");
        return false;
    }
}
</script>
</body>
</html>