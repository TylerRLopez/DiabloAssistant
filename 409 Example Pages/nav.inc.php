<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 1/30/2018
 * Time: 8:33 AM
 */
$currentfile = basename($_SERVER['PHP_SELF']);
?>
***ADD WEBSITE MAIN NAVIGATION HERE***
<ul>
    <?php
    echo ($currentfile == "index.php") ? "<li>Home</li>" : "<li><a href='index.php'>Home</a></li>";
    echo ($currentfile == "exampleform.php") ? "<li>Example Form</li>" : "<li><a href='exampleform.php'>Example Form</a></li>";
    ?>
</ul>
