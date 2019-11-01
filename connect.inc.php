<?php

/* CREATE A CONNECTION TO THE SERVER */
try{
    $connString = "mysql:host=localhost;dbname=s18c409trlopez";
    $user = "s18c409trlopez";
    $pass = "s18c409trlopez!";
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}

