<?php

$fname = $_SESSION['fname'];
$pagename = "Account Information";
$showform = 0;

$errorfname = $errorlname = $erroruname = $erroremail = "";
$errormsg = 0;

require_once "connect.inc.php";
require_once "header.php";

try
{
    $sqlusers = "SELECT * FROM users WHERE uname = :uname";
    $stmtusers = $pdo->prepare($sqlusers);
    $stmtusers->bindValue('uname', $_SESSION['uname']);
    $stmtusers->execute();
    $row = $stmtusers->fetch();
}//try
catch (PDOException $e)
{
    echo "<p class='error'>ERROR fetching users! " .$e->getMessage() . "</p>";
    exit();
}

if(isset($_POST['submit'])) {
    $showform = 1;
}

if(isset($_POST['submitChanges'])) {

    //Sanitizing Data
    $formfield['fname'] = trim($_POST['fname']);
    $formfield['lname'] = trim($_POST['lname']);
    $formfield['uname'] = strtolower(trim($_POST['uname']));
    $formfield['email'] = strtolower(trim($_POST['email']));

    //Checking for empty fields
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

    //Checking for duplicate usernames
    if ($formfield['uname'] != $row['uname']) {
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
        } catch (PDOException $e) {
            echo "<p class='error'> ERROR selecting users!" . $e->getMessage();
            echo "</p>";
        }
    }

    //Checking for duplicate emails
    if($formfield['email'] != $row['email']) {
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
        } catch (PDOException $e) {
            echo "<p class='error'> ERROR selecting email!" . $e->getMessage();
            echo "</p>";
        }
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
            //Updating the database

            //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
            $sql = "UPDATE users 
                    SET fname = :fname, lname = :lname, email = :email, uname = :uname 
                    WHERE uname = :unameold";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':fname', $formfield['fname']);
            $stmt->bindValue(':lname', $formfield['lname']);
            $stmt->bindValue(':email', $formfield['email']);
            $stmt->bindValue(':uname', $formfield['uname']);
            $stmt->bindValue(':unameold', $_SESSION['uname']);
            $stmt->execute();

            header('Location: '.$_SERVER['PHP_SELF']);
        }//end try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
            exit();
        }//else error inserting into database
    }//else inserting logic
}

if ($showform == 0) { ?>
    <table class="myAccountTable">
        <tr>
            <th>First Name:</th>
            <td><?php echo $row['fname'];?></td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td><?php echo $row['lname'];?></td>
        </tr>
        <tr>
            <th>User Name:</th>
            <td><?php echo $row['uname'];?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo $row['email'];?></td>
        </tr>
        <tr>
            <th>Profile Picture:</th>
            <td>TODO</td>
        </tr>
        <tr><td colspan="2"><form method="post" action="account.php"><input name="submit" id="submit" type="submit" value="Click me to change information!"/></form></td></tr>
    </table>
<?php } elseif ($showform == 1) { ?>
    <form name="infoChange" id="infoChange" method="post" action="account.php">
        <table class="myAccountTable">
            <tr>
                <th>First Name:</th>
                <td><input type="text" id="fname" name="fname" size="25" value="<?php if(isset($formfield['fname'])){echo $formfield['fname'];} else { echo $row['fname'];} ?>"/><span class="error"> <?php if(isset($errorfname)){echo $errorfname;} ?></span></td>
            </tr>
            <tr>
                <th>Last Name:</th>
                <td><input type="text" id="lname" name="lname" size="25" value="<?php if(isset($formfield['lname'])){echo $formfield['lname'];} else { echo $row['lname'];} ?>"/><span class="error"> <?php if(isset($errorlname)){echo $errorlname;} ?></span></td>
            </tr>
            <tr>
                <th>User Name:</th>
                <td><input type="text" id="uname" name="uname" size="25" value="<?php if(isset($formfield['uname'])){echo $formfield['uname'];} else { echo $row['uname'];} ?>"/><span class="error"> <?php if(isset($erroruname)){echo $erroruname;} ?></span></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><input type="email" id="email" name="email" size="25" value="<?php if(isset($formfield['email'])){echo $formfield['email'];} else { echo $row['email'];} ?>"/><span class="error"> <?php if(isset($erroremail)){echo $erroremail;} ?></span></td>
            </tr>
            <tr>
                <th>Profile Picture:</th>
                <td>TODO</td>
            </tr>
            <tr><td colspan="2"><form method="post" action="account.php"><input name="submitChanges" id="submitChanges" type="submit" value="Submit"/></form></td></tr>
        </table>
    </form>
<?php } ?>
<?php require_once "footer.php";?>
