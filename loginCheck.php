<?php

if(isset($_SESSION['uname'])) {
    echo "<p class=''error'>You are already logged in!</p>";
    require_once "footer.php";
    exit();
}
?>