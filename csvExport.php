<?php


require_once "connect.inc.php";

header("Content-Transfer-Encoding: ascii");
header("Content-Disposition: attachment; filename=forumCSV.csv");
header("Content-Type: text/comma-separated-values");
?>

section, user, contents, title, date

<?php

try {
    $sql = "SELECT * from forums";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<p class='error'>ERROR fetching users! " .$e->getMessage() . "</p>";
//    header("Location: forum.php");
    exit();
}

foreach ($result as $row) {
    $cleancontents = str_replace(['"', ',', "\r", "\n"], " ", $row['contents']);
    $cleantitle = str_replace(['"', ',', "\r", "\n"], " ", $row['title']);

    echo $row['section'] . "," . $row['user'] . "," . $cleancontents . "," . $cleantitle . "," . $row['date'] . "\n";
}

?>