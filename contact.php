<?php


$pagename = "Contact Us!";
require_once "header.php";
$errormsg = 0;
$errormessage = "";
$erroremail = "";
$errorsubject = "";

$showform = 1;

?>

<?php

if(isset($_POST['submit'])) {
    //sanitizing email name, subject name, and message contents
    $formfield['email'] = strtolower(trim($_POST['email']));
    $formfield['subject'] = trim($_POST['subject']);
    $formfield['message'] = trim($_POST['message']);

    //checking for empty fields
    if (empty($formfield['email'])) {
        $erroremail = "Your email is required.";
        $errormsg = 1;
    }//email field
    if (empty($formfield['subject'])) {
        $errorsubject = "A subject is required.";
        $errormsg = 1;
    }//subject field
    if (empty($formfield['message'])) {
        $errormessage = "A message is required.";
        $errormsg = 1;
    }//message field

    if ($errormsg != 0) {
        echo "<p class='error'>THERE ARE ERRORS!</p>";
        echo "<p class='error'>" . $erroremail . "</p>";
        echo "<p class='error'>" . $errormessage . "</p>";
        echo "<p class='error'>" . $errorsubject . "</p>";
    } else if ($errormessage == 0) {

        $showform = 0;

        $myEmail = "trlopez@coastal.edu";
        $from = $formfield['email'];
        $subject = $formfield['subject'];
        $message = $formfield['message'];

        $headers = 'FROM: ' . $from;
        mail($myEmail, $subject, $message, $headers, null);

    }
}

if($showform == 1){ ?>
    <form name="emailInfo" id="emailInfo" method="post" action="contact.php" >
        <table id="contactTable">
            <tr>
                <th>Email: </th>
                <td><input type="email" name="email" id="email" /></td>
            </tr>
            <tr>
                <th>Subject: </th>
                <td><input type="text" name="subject" id="subject" /></td>
            </tr>
            <tr>
                <th>Message: </th>
                <td><textarea name="message" id="message" ></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input id="contactSubmit" type="submit" name="submit" id="submit" /></td>
            </tr>
        </table>
    </form>


<?php } elseif ($showform == 0) { ?>
        <h3>Your email has been sent!</h3>

    <?php }
require_once "footer.php";
?>
