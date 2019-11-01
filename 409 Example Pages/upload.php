<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 3/26/2018
 * Time: 12:41 AM
 */
$pagename = "Home Page";
include_once "header.inc.php";

//check for file errors----------------------------------------------
$fileError ="";

if(!isset($_FILES['myFile']))
{
    $fileError .="Error! The expected file wasn't a part of the submitted form.<br>";
}

if($_FILES['myFile']['error'] != 0)
{
    $fileError .="Error! The file upload failed.<br>";
}

//perform file changes----------------------------------------------
echo "<p>Just printing out what we are doing to the file as we go.  This can be consolidated.</p>";

$origFile= $_FILES['myFile']['name'];
echo "Original File: " . $origFile;
echo "<br>";

$trimmedFile = trim($origFile);
echo "Trimmed File: " . $trimmedFile;
echo "<br>";

$fixedFile=str_replace(" ","_",$trimmedFile);
echo "Fixed File: " . $fixedFile;
echo "<br>";

$finalFile = strtolower($fixedFile);
echo "Final File: " . $finalFile;
echo "<br>";

echo "Temporary File: " . $_FILES['myFile']['tmp_name'];
echo "<br>";
//Moving the file to the final directory
if(!move_uploaded_file($_FILES['myFile']['tmp_name'], "/var/www/html/uploads/".$finalFile))
{
    echo "<br>Error! The file could not be moved.<br>";
}
else
{
    //If the file move works, here is a link to check it.
    echo "<p>The file is <a href='/uploads/" .$finalFile ."' target='_blank'>" .$finalFile . "</a></p>";
}
//Here is some more code for checking things out.

    echo '<pre>';
    echo 'Here is some more debugging info:';
    print_r($_FILES);
    print "</pre>";
include_once "footer.inc.php";
?>