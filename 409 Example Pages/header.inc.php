<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 1/30/2018
 * Time: 8:33 AM
 */
require_once "connect.inc.php";

//turn on error reporting for debugging - Page 699
error_reporting(E_ALL);
ini_set('display_errors','1'); //change this after testing is complete

//set the time zone
ini_set( 'date.timezone', 'America/New_York');
date_default_timezone_set('America/New_York');

//set current time
$rightnow = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>***ADD WEBSITE TITLE HERE***</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<header>
    <h1>***ADD WEBSITE MAIN HEADING HERE***</h1>
    <nav>
    <?php require_once "nav.inc.php"; ?>
    </nav>
</header>
<main>
    <h2><?php  echo $pagename; //pagename is assigned a value on each individual page ?></h2>

