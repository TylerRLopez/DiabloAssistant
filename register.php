<?php

$pagename = "Register";
$showform = 1;
$errormsg = 0;
$errorfname = $errorlname = $erroruname = $erroremail = $errorpwd = $errorpwdc = $errorpwdmatch = $erroranswer = $errorREGEX = "";

$accessLevel = 0;//default user access level



require_once "header.php";
require_once "loginCheck.php";

require_once "connect.inc.php";//for access to the database

//retrieve Security Questions
try {
    $sql = "SELECT question FROM security_question";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
catch (PDOException $e)
{
    echo "<p class='error'> ERROR getting security questions!" .$e->getMessage(); echo "</p>";
}



if(isset($_POST['submit'])) {
        //Sanitizing Data
        $formfield['fname'] = trim($_POST['fname']);
        $formfield['lname'] = trim($_POST['lname']);
        $formfield['uname'] = strtolower(trim($_POST['uname']));
        $formfield['email'] = strtolower(trim($_POST['email']));
        $formfield['pwd'] = trim($_POST['pwd']);
        $formfield['pwdc'] = trim($_POST['pwdc']);
        $formfield['answer'] = strtolower(trim($_POST['answer']));
        $formfield['qnumber'] = $_POST['qnumber'];

        //Checking for empty fields
        if (empty($formfield['pwd'])) {
            $errorpwd = "The password is required.";
            $errormsg = 1;
        }
        if (empty($formfield['pwdc'])) {
            $errorpwdc = "The password confirmation is required.";
            $errormsg = 1;
        }
        if (empty($formfield['fname'])) {
            $errorfname = "The first name is required.";
            $errormsg = 1;
        }
        if (empty($formfield['lname'])) {
            $errorlname = "The last name is required.";
            $errormsg = 1;
        }
        if (empty($formfield['uname'])) {
            $erroruname = "The username is required.";
            $errormsg = 1;
        }
        if (empty($formfield['email'])) {
            $erroremail = "The email is required.";
            $errormsg = 1;
        }
        if (empty($formfield['answer'])) {
            $erroranswer = "A security question answer is required.";
            $errormsg = 1;
        }
        //Checking to make sure passwords match
        if ($formfield['pwd'] != $formfield['pwdc']) {
            $errorpwdmatch = "The passwords do not match!";
            $errormsg = 1;
        }

        //The password must contain one or more; uppercase, lowercase, and number. The password length must be 8 or more.
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/';
        $match = preg_match($regex, $formfield['pwd']);
        if(!$match) {
            $errorREGEX = "The password must contain atleast 1 uppercase, 1 lowercase, 1 number, and must have a minimum length of 8.";
            $errormsg = 1;
        }


    //Checking for duplicate usernames
        try {
            $sqlusers = "SELECT uname FROM users WHERE uname = :uname";
            $stmtusers = $pdo->prepare($sqlusers);
            $stmtusers->bindValue('uname', $formfield['uname']);
            $stmtusers->execute();
            $countusers = $stmtusers->rowCount();
            if ($countusers > 0) {
                $erroruname = " The Username is already taken.";
                $errormsg = 1;
            }
        }
        catch (PDOException $e)
        {
            echo "<p class='error'> ERROR selecting users!" .$e->getMessage(); echo "</p>";
        }

        //Checking for duplicate emails
        try {
            $sqlemail = "SELECT email FROM users WHERE email = :email";
            $stmtemail = $pdo->prepare($sqlemail);
            $stmtemail->bindValue('email', $formfield['email']);
            $stmtemail->execute();
            $countemail = $stmtemail->rowCount();
            if ($countemail > 0) {
                $erroremail = " The email has already been used.";
                $errormsg = 1;
            }
        }
        catch (PDOException $e)
        {
            echo "<p class='error'> ERROR selecting email!" .$e->getMessage(); echo "</p>";
        }

        //testing if there were errors
        if ($errormsg != 0)
        {
            //print error message
            echo "<p>There was a problem processing your registration.<br /><br />Please make sure that you filled everything out, and that you met the requirements.</p>";
        }
        else
        {
            try
            {
                //Inserting into the database

                //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
                $sql = "INSERT INTO users (uname, accessLevel, password, email, fname, lname, answer, qnumber)
                    VALUES (:uname, :accessLevel, :password, :email, :fname, :lname, :answer, :qnumber)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':uname', $formfield['uname']);
                $stmt->bindValue(':accessLevel', $accessLevel);
                $stmt->bindValue(':password', password_hash($formfield['pwd'], PASSWORD_BCRYPT));
                $stmt->bindValue(':email', $formfield['email']);
                $stmt->bindValue(':fname', $formfield['fname']);
                $stmt->bindValue(':lname', $formfield['lname']);
                $stmt->bindValue(':answer', password_hash($formfield['answer'], PASSWORD_BCRYPT));
                $stmt->bindValue(':qnumber', $formfield['qnumber']);
                $stmt->execute();

                $showform = 0;
            }//end try
            catch (PDOException $e)
            {
                echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
                exit();
            }//else error inserting into database
        }//else inserting logic

    $targetDir = "";

    }//END submit logic

if ($showform == 1){ ?>

    <form name="register" id="register" method="post" action="register.php" enctype="multipart/form-data">
            <table id="registerTable">
                <tr>
                    <th><label for="fname">First Name</label></th>
                    <td><input type="text" id="fname" name="fname" size="25" maxlength="50" value="<?php if(isset($formfield['fname'])){echo $formfield['fname'];} ?> "/>*<span class="error"> <?php if(isset($errorfname)){echo $errorfname;} ?></span></td>
                </tr>
                <tr>
                    <th><label for="lname">Last Name</label></th>
                    <td><input type="text" id="lname" name="lname" size="25" maxlength="50" value="<?php if(isset($formfield['lname'])){echo $formfield['lname'];} ?>"/>*<span class="error"> <?php if(isset($errorlname)){echo $errorlname;} ?></span></td>
                </tr>
                <tr>
                    <th><label for="email">Email</label></th>
                    <td><input type="email" id="email" name="email" size="25" value="<?php if(isset($formfield['email'])){echo $formfield['email'];} ?>"/>*<span class="error"> <?php if(isset($erroremail)){echo $erroremail;} ?></span></td>
                </tr>
                <tr>
                    <th><label for="uname">User Name</label></th>
                    <td><input type="text" id="uname" name="uname" size="25" maxlength="40" value="<?php if(isset($formfield['uname'])){echo $formfield['uname'];} ?>"/>*<span class="error"> <?php if(isset($erroruname)){echo $erroruname;} ?></span></td>
                </tr>
                <tr>
                    <th><label for="pwd">Password</label></th>
                    <td><input type="password" id="pwd" name="pwd" size="25" maxlength="40" value=""/>*<span class="error"> <?php if(isset($errorpwd)){echo $errorpwd;} ?></span>
                        <p><span id="pwdInformation">Password must contain at least 1 uppercase, 1 lowercase, 1 number, and have a length of atleast 8</span></p>
                    </td>

                </tr>
                <tr>
                    <th><label for="pwdc">Confirm Password</label></th>
                    <td><input type="password" id="pwdc" name="pwdc" size="25" maxlength="40" value=""/>*<span class="error"> <?php if(isset($errorpwdc)){echo $errorpwdc;} ?><br /><?php if(isset($errorpwdmatch)){echo $errorpwdmatch;} ?></span></td>
                </tr>
                <tr>
                    <th><label for="squestion">Security Question</label></th>
                    <td><select name="qnumber" id="qnumber">
                            <?php
                            $i = 0;
                            foreach ($result as $sq) {
                                echo '<option value="'.$i.'">'.$sq["question"].'</option>';
                                $i++;
                            }?>
                        </select></td>
                </tr>
                <tr>
                    <th>Profile Picture: </th>
                    <td><input type="file" name="profilepicture" id="profilepicture" /></td>
                </tr>
                <tr>
                    <th><label for="answer">Security Answer</label></th>
                    <td><input type="text" id="answer" name="answer" size="25" maxlength="40" value=""/>*<span class="error"> <?php if(isset($erroranswer)){echo $erroranswer;} ?><br /></span></td>
                </tr>
                <tr>
                    <td colspan="2"><input id="registerSubmit" type="submit" id="submit" name="submit" value="submit"/></td>
                </tr>
            </table>
    </form>


<?php }//END showform 1

if ($showform == 0){ ?>

    <h2>Registration Complete! Welcome <?php echo $formfield['fname'] ?>!</h2>
    <p>Please head over to <a href="login.php" >Log In</a> and try out your new member status!</p>


<?php }//END showform 0 ?>



<?php
require_once "footer.php";
?>

