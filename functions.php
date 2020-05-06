<?php

    function fetch_word_array($word_file)
    {
        $file = fopen($word_file,'r');
           if ($file)
        {
            $random_line = null;
            $line = null;
            $count = 0;
            while (($line = fgets($file)) !== false) 
            {
                $count++;
                if(rand() % $count == 0) 
                {
                      $random_line = trim($line);
                }
        }
        if (!feof($file)) 
        {
            fclose($file);
            return null;
        }else 
        {
            fclose($file);
        }
    }
        $answer = str_split($random_line);
        return $answer;
    }

    function hide_characters($answer)
    {
        $no_of_hidden_chars = floor((sizeof($answer)/2) + 1);
        $count = 0;
        $hidden = $answer;
        while ($count < $no_of_hidden_chars )
        {
            $rand_element = rand(0,sizeof($answer)-2);
            if( $hidden[$rand_element] != '_' )
            {
                $hidden = str_replace($hidden[$rand_element],'_',$hidden,$replace_count);
                $count = $count + $replace_count;
            }
        }
        return $hidden;
    }

    function check_and_replace($user_input, $hidden, $answer)
    {
        $i = 0;
        $wrong_guess = true;
        while($i < count($answer))
        {
            if ($answer[$i] == $user_input)
            {
                $hidden[$i] = $user_input;
                $wrong_guess = false;
            }
            $i = $i + 1;
        }
        if (!$wrong_guess) $_SESSION['attempts'] = $_SESSION['attempts'] - 1;
        return $hidden;
    }
    
    

    function check_game_over($MAX_ATTEMPTS, $user_attempts, $answer, $hidden)
    {
        if ($user_attempts >= $MAX_ATTEMPTS)
            {
                echo "<h1 class='text-danger'>Game Over. The correct word was ";
                
                foreach ($answer as $letter) echo $letter;
                echo "</h1><img src='hanged.jpg'>";
                echo '<br><form method="post"><input type="submit" class="btn btn-warning" name="new_word" value="Try another Word"/></form><br>';
                die();
            }
            if ($hidden == $answer)
            {
                echo "<h1 class='text-success'>Congratulations You Win! The correct word is <span class='text-primary'>";
                foreach ($answer as $letter) echo $letter;
                echo '</span></h1><br><form action="" method="post"><input type="submit" class="btn btn-warning" name="new_word" value="Try another Word"/></form><br>';
                die();
            }
    }
?>