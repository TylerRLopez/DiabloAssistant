<?php

//turn on error reporting for debugging - Page 699
error_reporting(E_ALL);
ini_set('display_errors','1'); //change this after testing is complete

date_default_timezone_set("America/New_York");

session_start();

if (isset($_COOKIE['firstName'])) {
    $cookieFname = $_COOKIE['firstName'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Tyler's 409 Website</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>

<header>
    <?php require_once "nav.php"; ?>
</header>
<main>

    <div id="title">
        <h1><u><?php echo $pagename;?></u><br/></h1>
    </div>
    <div class="content">
        <?php if(isset($_COOKIE['firstName'])) {echo '<h5>Welcome '.$cookieFname.', we got your name from a cookie! :)</h5><br><br>';}?>
