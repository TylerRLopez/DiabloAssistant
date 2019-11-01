<?php
/**
 * Created by PhpStorm.
 * User: jennis
 * Date: 3/26/2018
 * Time: 12:41 AM
 */

$pagename = "Home Page";
include_once "header.inc.php";
?>
<form action="upload.php" name="myform" id="myform" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <th><label for="myFile">Select image to upload:</label></th>
            <td><input type="file" name="myFile" id="myFile"></td>
        </tr>
        <tr>
            <th><label for="submit">Upload Now</label></th>
            <td><input type="submit" name="submit" id="submit" value="Upload NOW" ></td>
        </tr>
    </table>
</form>
<?php
include_once "footer.inc.php";
?>