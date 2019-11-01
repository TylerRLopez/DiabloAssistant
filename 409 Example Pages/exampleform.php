<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 3/13/2018
 * Time: 8:54 AM
 */
$pagename ="***ADD PAGE TITLE (EXAMPLE:  FABULOUS FORM PAGE) HERE HERE***";
include_once "header.inc.php";

//set initial variables
$showform = 1;  // show form is true
$errormsg = 0;
$erroremail = "";
$errorpwd = "";
$errorpwd2 = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    /* ***********************************************************************
     * SANITIZE USER DATA
     * Use strtolower()  for emails, usernames and other case-sensitive info
     * Use trim() for ALL user-typed data
     * ***********************************************************************
     */
    $formdata['email'] = trim(strtolower($_POST['email']));
    $formdata['pwd'] = trim($_POST['pwd']);
    $formdata['pwd2'] = trim($_POST['pwd2']);

    /* ***********************************************************************
     * CHECK EMPTY FIELDS
     * Check for empty data for every required field
     * Do not do for things like apartment number, middle initial, etc.
     * ***********************************************************************
     */
        if (empty($formdata['email'])) {
            $erroremail = "<span class='error'>The email field is required.</span>";
            $errormsg = 1;
        }
        if (empty($formdata['pwd'])) {
            $errorpwd = "<span class='error'>The password field is required.</span>";
            $errormsg = 1;
        }
        if (empty($formdata['pwd2'])) {
            $errorpwd2 = "<span class='error'>The confirmation password field is required.</span>";
            $errormsg = 1;
        }

    /* ***********************************************************************
     * CHECK MATCHING FIELDS
     * Used for important fields that need confirmation
     * Usually seen with emails or passwords.
     * ***********************************************************************
     */
    if($formdata['pwd'] != $formdata['pwd2'])
    {
        $errormsg = 1;
        $errorpwd2= "<span class='error'>Passwords must match.</span>";
    }

    /* ***********************************************************************
     * CHECK EXISTING ENTRIES
     * Used if you cannot have duplicate entries in a database
     * Usually seen for emails and usernames
     * ***********************************************************************
     */
    try
    {
        $sql = "SELECT * FROM members WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $formdata['email']);
        $stmt->execute();
        $countemail = $stmt->rowCount();
        if ($countemail > 0)
        {
            $errormsg = 1;
            $erroremail = "<span class='error'>Email already taken.</span>";
        }
    }
    catch (PDOException $e)
    {
        echo "<p class='error'>Error getting members!" . $e->getMessage() . "</p>";
        exit();
    }


     /* **********************************************************************
     * CONTROL OF PROGRAM AFTER ERROR CHECKING
     * Handles what we do with errors and without
     * ***********************************************************************
     */
    if($errormsg == 1)
    {
        echo "<p class='error'>There are errors.  Please make corrections and resubmit.</p>";
    }
    else{

        /* ***********************************************************************
         * HASH PASSWORDS
         * ************************************************************************
        */
        $hashedpwd = password_hash($formdata['pwd'], PASSWORD_BCRYPT);

        /* ***********************************************************************
         * INSERT INTO DATABASE
         *
         */
        try{
            //query the data
            $sql = "INSERT INTO members (email, pwd, inputdate) VALUES (:email, :pwd, :inputdate) ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $formdata['email']);
            $stmt->bindValue(':pwd', $hashedpwd);
            $stmt->bindValue(':inputdate', $rightnow);
            $stmt->execute();
        }
        catch (PDOException $e)
        {
            die( $e->getMessage() );
        }
        echo "<p class='success'>Thank you for entering your data!</p>";
        $showform = 0;

    } // else errormsg
}//submit

//display form if Show Form Flag is true
if($showform == 1)
{
?>
    <form name="simpleform" id="simpleform" method="post" action="exampleform.php">

        <table>
            <tr><th><label for="email">Email:</label></th>
                <td><input name="email" id="email" type="email" size="40" placeholder="*required email"
                           value="<?php if(isset($formdata['email'])){echo $formdata['email'];}?>"
                    /><span class="error"><?php if(isset($erroremail)){echo $erroremail;}?></span></td>
            </tr>
            <tr><th><label for="pwd">Password:</label></th>
                <td><input name="pwd" id="pwd" type="password" size="40" placeholder="*required password"
                           value="<?php if(isset($formdata['pwd'])){echo $formdata['pwd'];}?>"
                    /><span class="error"><?php if(isset($errorpwd)){echo $errorpwd;}?></span></td>
            </tr>
            <tr><th><label for="pwd2">Confirm Password:</label></th>
                <td><input name="pwd2" id="pwd2" type="password" size="40" placeholder="*required password confirmation"
                           value="<?php if(isset($formdata['pwd2'])){echo $formdata['pwd2'];}?>"
                    /><span class="error"><?php if(isset($errorpwd2)){echo $errorpwd2;}?></span></td>
            </tr>
            <tr><th><label for="submit">Submit: </label></th>
                <td><input type="submit" name="submit" id="submit" value="submit"/></td>
            </tr>
        </table>
    </form>
<?php
}//end showform
include_once "footer.php";
?>










