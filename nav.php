<?php

$currentfile = basename($_SERVER['PHP_SELF']);
?>
<div class="nav">
    <?php
    echo ($currentfile == "index.php") ? "<div>Home</div>" : "<div><a href='index.php'>Home</a></div>";
    echo ($currentfile == "contact.php") ? "<div>Contact Me</div>" : "<div><a href='contact.php'>Contact Me</a></div>";
    echo ($currentfile == "forum.php") ? "<div>Forums</div>" : "<div><a href='forum.php'>Forums</a></div>";

    //if logged in
    if (isset($_SESSION['uname'])) {
            echo ($currentfile == "account.php") ? "<div class='navLeft'>My Account</div>" : "<div class='navLeft'><a href='account.php'>My Account</a></div>";
            echo ($currentfile == "logout.php") ? "<div class='navLeft leftMarginDelete'>Logout</div>" : "<div class='navLeft leftMarginDelete'><a href='logout.php'>Logout</a></div>";

    } else {//not logged in
            echo ($currentfile == "register.php") ? "<div class='navLeft'>Register</div>" : "<div class='navLeft'><a href='register.php'>Register</a></div>";
            echo ($currentfile == "login.php") ? "<div class='navLeft leftMarginDelete'>Login</div>" : "<div class='navLeft leftMarginDelete'><a href='login.php'>Login</a></div>";

    }
    ?>
</div>
