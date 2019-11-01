<?php

$pagename = "Login";
$showform = 1;

$errormsg = 0;
$erroruname = $errorpwd = "";

require_once "header.php";

require_once "loginCheck.php";//Checks to see if user is logged in

require_once "connect.inc.php";//for access to the database

if(isset($_POST['submit'])) {

    //sanitizing username and password
    $formfield['uname'] = strtolower(trim($_POST['uname']));
    $formfield['pwd'] = trim($_POST['pwd']);

    //checking for empty fields
    if (empty($formfield['pwd'])) {
        $errorpwd = "The password is required.";
        $errormsg = 1;
    }//password field
    if (empty($formfield['uname'])) {
        $erroruname = "The username is required.";
        $errormsg = 1;
    }//username field

    if ($errormsg == 0)
    {
        try
        {
            //Checking for duplicate users
            $sqlusers = "SELECT * FROM users WHERE uname = :uname";
            $stmtusers = $pdo->prepare($sqlusers);
            $stmtusers->bindValue(':uname', $formfield['uname']);
            $stmtusers->execute();
            $row = $stmtusers->fetch();
            $countusers = $stmtusers->rowCount();

            if($countusers < 1) {
                echo "<p class='error'>This user doesn't exist</p>";
            }//user not found
            else {
                if(password_verify($formfield['pwd'], $row['password'])) {
                    //user logged in
                    $_SESSION['fname']= $row['fname'];
                    $_SESSION['uname']= $row['uname'];
                    $_SESSION['accessLevel']= $row['accessLevel'];
                    $showform = 0;
                }//set session vars
                else {
                    echo "<p class='error'>The passwords do not match! Please try again.</p>";
                }//password verify
            }//username exists
        }//try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR fetching users! " .$e->getMessage() . "</p>";
            exit();
        }

        $cookie_name = "firstName";
        $cookie_value = $_SESSION['fname'];

        setcookie($cookie_name,$cookie_value, time() + (86400 * 30), "/");

    }
}//end if submitted

if (isset($_POST['passReset'])) {
    header("Location: passReset.php");
    exit();
}

if($showform == 1)
{?>
    <form method="post" name="login" id="login" action="login.php">
        <table>
            <tr>
                <th><label for="uname">User Name</label></th>
                <td><input type="text" id="uname" name="uname" size="25" value="<?php if(isset($formfield['uname'])){echo $formfield['uname'];} ?>"/><span class="error"> <?php if(isset($erroruname)){echo $erroruname;} ?></span></td>
            </tr>
            <tr>
                <th><label for="pwd">Password</label></th>
                <td><input type="password" id="pwd" name="pwd" size="25"/><span class="error"> <?php if(isset($errorpwd)){echo $errorpwd;} ?></span></td>
            </tr>
            <tr>
                <td><input id="loginSubmit" type="submit" id="submit" name="submit" value="submit"/></td>
                <td><input id="loginSubmit" type="submit" name="passReset" value="Forgot Password"/></td>
            </tr>
        </table>
    </form>
<?php }//end showform
else {
    echo "<p>You have been successfully logged in!</p>";
}

require_once "footer.php" ?>
