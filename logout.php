<?php

$pagename = "Logout";
session_start();
session_unset();
session_destroy();

require_once "header.php";

?>

<p>You have been successfully logged out!</p>

<?php
require_once "footer.php"
?>
