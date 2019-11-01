<?php


$pagename = "Password Reset";

$errorEmail = $errorpwd = $errorcpwd = $errorpwdnomatch = "";
$errorMsg = 0;

$showform = 0;

$prevEmail = "";

require_once "header.php";
require_once "connect.inc.php";

if (isset($_GET['q'])) {
    $prevEmail = $_GET['q'];
    $showform = 2;
}

if (isset($_POST['submit'])) {
    //Sanitizing email
    $formfield['email'] = trim(strtolower($_POST['email']));

    //Checking to see if email is empty
    if (empty($formfield['email'])) {
        $errorEmail = "You must enter a email!";
        $errorMsg = 1;
    }

    if ($errorMsg == 0) {//no errors
        try {
            //Checking for duplicate users
            $sqlusers = "SELECT email FROM users WHERE email = :email";
            $stmtusers = $pdo->prepare($sqlusers);
            $stmtusers->bindValue(':email', $formfield['email']);
            $stmtusers->execute();
            $row = $stmtusers->fetch();
            $countusers = $stmtusers->rowCount();

            if ($countusers < 1) {
                echo "<p class='error'>This email doesn't exist</p>";
            }//email not found
        } catch (PDOException $e) {
            echo "<p class='error'>ERROR fetching users! " .$e->getMessage() . "</p>";
            exit();
        }

        if($countusers == 1) {//Email found, send reset link
            $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

            $uniqueReset = hash('sha512', $salt.$formfield["email"]);

            $resetLink = "http://ccuresearch.coastal.edu/trlopez/csci409sp18/passReset.php?q=".$uniqueReset;

            $subject = "409 Password Reset";

            $messageBody = "Hello user!\nWe have gotten a request to reset a password with this email, if this is not you then please ignore this otherwise to continue with the reset click this link:\n".$resetLink;

            mail($formfield['email'], $subject, $messageBody);
            echo "An email has been sent to ".$_POST['email']." with instructions on how to reset your password.";

            $showform = 1;
        }

    } else {//errors
        echo "<span class='error'>There were errors!</span>";
    }
}

if (isset($_POST['phase2'])) {
    //Sanitizing
    $formfield['email'] = trim(strtolower($_POST['email']));
    $formfield['pwd'] = trim($_POST['pwd']);
    $formfield['cpwd'] = trim($_POST['cpwd']);
    $hash = $_POST['q'];

    //Checking to see if email is empty
    if (empty($formfield['email'])) {
        $errorEmail = "You must enter a email!";
        $errorMsg = 1;
    }
    if (empty($formfield['pwd'])) {
        $errorEmail = "You must enter a Password!";
        $errorMsg = 1;
    }
    if (empty($formfield['cpwd'])) {
        $errorEmail = "You must enter a password confirmation!";
        $errorMsg = 1;
    }

    //checking to see passwords match
    if (!$formfield['pwd'] == $formfield['cpwd']) {
        $errorpwdnomatch = "Your passwords don't match!";
        $errorMsg = 1;
    }

    if($errorMsg != 1) {
        $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

        $resetkey = hash('sha512', $salt.$formfield['email']);

        if($resetkey == $hash) {
            try
            {
                //Updating the database

                //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
                $sql = "UPDATE users 
                    SET password = :password 
                    WHERE email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':password', password_hash($formfield['pwd'], PASSWORD_BCRYPT));
                $stmt->bindValue(':email', $formfield['email']);
                $stmt->execute();

                $showform = 3;
            }//end try
            catch (PDOException $e)
            {
                echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
                exit();
            }//else error inserting into database
        }

    } else {
        echo "<span class='error'>There are errors!</span>";
    }
}

if ($showform == 0) {?>
    <form method="post" action="passReset.php" name="passReset" id="passReset">
        <table class="passResetTable" >
            <tr>
                <th>Email:</th>
                <td><input type="email" name="email" id="email" value="<?php if(isset($formfield['email'])){echo $formfield['email'];} ?>"/><span class="error"> <?php if(isset($errorEmail)){echo $errorEmail;} ?></span></td>
            </tr>
            <tr><td colspan="2"><input type="submit" name="submit" id="submit" value="Email me the reset link!" /></td></tr>
        </table>
    </form>
<?php } elseif($showform == 2) {?>
    <form action="passReset.php" method="post" name="phase2passreset" id="phase2passreset" >
        <table>
            <?php if (isset($errorpwdnomatch)) {echo "<span class='error'>".$errorpwdnomatch."</span>";} ?>
            <tr>
                <th>Email:</th>
                <td><input type="email" name="email" id="email" value="<?php if(isset($formfield['email'])){echo $formfield['email'];} ?>"/><span class="error"> <?php if(isset($errorEmail)){echo $errorEmail;} ?></span></td>
            </tr>
            <tr>
                <th><label for="pwd">New Password</label></th>
                <td><input type="password" id="pwd" name="pwd" size="25"/><span class="error"></span></td>
            </tr>
            <tr>
                <th><label for="pwd">Confirm Password</label></th>
                <td><input type="password" id="cpwd" name="cpwd" size="25"/><span class="error"></span></td>
            </tr>
            <tr><td colspan="2"><input type="submit" name="phase2" id="submit" value="Start Reset!" /></td></tr>
            <tr><input type="hidden" name="q" value="<?php if (isset($_GET['q'])) { echo $_GET['q'];} ?>"/></tr>
        </table>
    </form>
<?php } elseif ($showform == 3) {
    echo "Your password has been reset!";
} ?>

<?php require_once "footer.php";?>
