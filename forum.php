<?php


$pagename = "Forums";

require_once "connect.inc.php";//To display the comments and things

require_once "header.php";

$showform = 0;
//Show form == 0 --> Normal Viewing
//Show form == 1 --> Post New Bug
//Show form == 2 --> Post New Comment
//Show form == 3 --> Post New Helpful Tips
//Show form == 4 --> Post New Suggestions

$counter = 0;

$errormsg = 0;
$errortitle = $errorcontent = "";

$date = date("m/d/Y");

if (isset($_POST['bugPost'])) {
    $showform = 1;
    $pagename = "New Bug Post";
}
if (isset($_POST['commentPost'])) {
    $showform = 2;
    $pagename = "New Comment Post";
}
if (isset($_POST['tipsPost'])) {
    $showform = 3;
    $pagename = "New Tips / Tricks Post";
}
if (isset($_POST['suggestionPost'])) {
    $showform = 4;
    $pagename = "New Suggestion Post";
}

//New Bug Post
if(isset($_POST['bugPostButton'])){
    $formfield['title'] = trim($_POST['title']);
    $formfield['content'] = trim(strip_tags($_POST['content']));
    $formfield['date'] = $date;
    $formfield['uname'] = $_SESSION['uname'];
    $formfield['section'] = "bugs";

    if(empty($formfield['title'])) {
        $errortitle = "You must have a title!";
        $errormsg = 1;
    }

    if(empty($formfield['content'])) {
        $errorcontent = "You must have a detailed description of the bug!";
        $errormsg = 1;
    }

    if($errormsg != 1) {
        try
        {
            //Inserting into the database

            //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
            $sql = "INSERT INTO forums (section, user, contents, title, date)
                    VALUES (:section, :user, :contents, :title, :date)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':section', $formfield['section']);
            $stmt->bindValue(':user', $formfield['uname']);
            $stmt->bindValue(':contents', $formfield['content']);
            $stmt->bindValue(':title', $formfield['title']);
            $stmt->bindValue(':date', $formfield['date']);
            $stmt->execute();

            header('Location: http://ccuresearch.coastal.edu/trlopez/csci409sp18/forum.php');
        }//end try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
            exit();
        }//else error inserting into database
    } else {
        $showform = 1;
    }
}//End bugPostLogic

//New Comment Post
if(isset($_POST['commentPostButton'])){
    $formfield['title'] = trim($_POST['title']);
    $formfield['content'] = trim(strip_tags($_POST['content']));
    $formfield['date'] = $date;
    $formfield['uname'] = $_SESSION['uname'];
    $formfield['section'] = "comments";

    if(empty($formfield['title'])) {
        $errortitle = "You must have a title!";
        $errormsg = 1;
    }

    if(empty($formfield['content'])) {
        $errorcontent = "You must have an actual comment!";
        $errormsg = 1;
    }

    if($errormsg != 1) {
        try
        {
            //Inserting into the database

            //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
            $sql = "INSERT INTO forums (section, user, contents, title, date)
                    VALUES (:section, :user, :contents, :title, :date)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':section', $formfield['section']);
            $stmt->bindValue(':user', $formfield['uname']);
            $stmt->bindValue(':contents', $formfield['content']);
            $stmt->bindValue(':title', $formfield['title']);
            $stmt->bindValue(':date', $formfield['date']);
            $stmt->execute();

            header('Location: http://ccuresearch.coastal.edu/trlopez/csci409sp18/forum.php');
        }//end try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
            exit();
        }//else error inserting into database
    } else {
        $showform = 2;
    }
}//End commentPostLogic

//New Tip Post
if(isset($_POST['tipPostButton'])){
    $formfield['title'] = trim($_POST['title']);
    $formfield['content'] = trim(strip_tags($_POST['content']));
    $formfield['date'] = $date;
    $formfield['uname'] = $_SESSION['uname'];
    $formfield['section'] = "tips";

    if(empty($formfield['title'])) {
        $errortitle = "You must have a title!";
        $errormsg = 1;
    }

    if(empty($formfield['content'])) {
        $errorcontent = "You must have an actual tip!";
        $errormsg = 1;
    }

    if($errormsg != 1) {
        try
        {
            //Inserting into the database

            //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
            $sql = "INSERT INTO forums (section, user, contents, title, date)
                    VALUES (:section, :user, :contents, :title, :date)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':section', $formfield['section']);
            $stmt->bindValue(':user', $formfield['uname']);
            $stmt->bindValue(':contents', $formfield['content']);
            $stmt->bindValue(':title', $formfield['title']);
            $stmt->bindValue(':date', $formfield['date']);
            $stmt->execute();

            header('Location: http://ccuresearch.coastal.edu/trlopez/csci409sp18/forum.php');
        }//end try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
            exit();
        }//else error inserting into database
    } else {
        $showform = 3;
    }
}//End tipPostLogic

//New suggestion Post
if(isset($_POST['suggestionPostButton'])){
    $formfield['title'] = trim($_POST['title']);
    $formfield['content'] = trim(strip_tags($_POST['content']));
    $formfield['date'] = $date;
    $formfield['uname'] = $_SESSION['uname'];
    $formfield['section'] = "suggestions";

    if(empty($formfield['title'])) {
        $errortitle = "You must have a title!";
        $errormsg = 1;
    }

    if(empty($formfield['content'])) {
        $errorcontent = "You must have an actual app suggestion!";
        $errormsg = 1;
    }

    if($errormsg != 1) {
        try
        {
            //Inserting into the database

            //YOU NEED TO ADD THE CODE FOR UNAME AND EMAIL
            $sql = "INSERT INTO forums (section, user, contents, title, date)
                    VALUES (:section, :user, :contents, :title, :date)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':section', $formfield['section']);
            $stmt->bindValue(':user', $formfield['uname']);
            $stmt->bindValue(':contents', $formfield['content']);
            $stmt->bindValue(':title', $formfield['title']);
            $stmt->bindValue(':date', $formfield['date']);
            $stmt->execute();

            header('Location: http://ccuresearch.coastal.edu/trlopez/csci409sp18/forum.php');
        }//end try
        catch (PDOException $e)
        {
            echo "<p class='error'>ERROR inserting into the database table! " .$e->getMessage() . "</p>";
            exit();
        }//else error inserting into database
    } else {
        $showform = 4;
    }
}//End suggestionPostLogic

try
{
    //Getting the forum data from the database
    $sql = "SELECT * FROM forums ORDER BY section ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
}//try
catch (PDOException $e)
{
    echo "<p class='error'>ERROR fetching users! " .$e->getMessage() . "</p>";
    exit();
}



if ($showform == 0) { //if user hasnt clicked post new comment
    if(isset($_SESSION['uname'])) {
        echo "<form name='bugPost' id='bugPost' method='post' action='forum.php'>
            <input type='submit' name='bugPost' id='bugPost' value='Post a new bug!'>
            </form><br><br>";
    } else {
        echo "<h3>Please log in to post content.</h3>
          <h3>Click on a section to browse its contents!</h3>
          <br>
          <br>
          ";
    }

    echo "<a href='csvExport.php'>Export forums contents into CSV</a><br><br>";

    if ((isset($_SESSION['uname'])) && ($_SESSION['accessLevel'] == 1)) {
        echo '
    <h4 class="forumTitle">Bugs</h4>
    <button type="button" id="bugButton">Click to show/hide bugs contents</button>
    <div class="forumDiv" id="bugs">
        
        <table class="forumTable">';

        foreach ($result as $row) {
            if ($row['section'] == "bugs") {
                $counter++;//counting how much content there is for the section
                echo "
                    <tr>
                        <th>By: <br>" . $row['user'] . "</th>
                        <td>
                            <span class='title'>" . $row['title'] . "<br></span>
                            Created: " . $row['date'] . "<BR>
                            
                            <div class='forumContentIndent'>
                                " . $row['contents'] . "
                            </div>";
                    if (($_SESSION['uname'] == $row['user']) || ($_SESSION['accessLevel'] == 1)) {echo "<a href='removeComment.php'>Delete</a>";} if($_SESSION['uname'] == $row['user']) { echo " | <a href='updateComment'>Modify</a>";}
                echo "</td>
                </tr>";
            }
        }
        echo "</table>";
        if ($counter == 0) {
            echo "There is no content available yet!";
        }

        $counter = 0;//reseting the counter
        echo "</div><br><br>";
    }?>


    <h4 class="forumTitle">Comments</h4>
    <?php if(isset($_SESSION['uname'])) {
        echo "<form name='commentPost' id='commentPost' method='post' action='forum.php'>
            <input type='submit' name='commentPost' id='commentPost' value='Post a new comment!'>
        </form>";
    } ?>
    <button type="button" id="commentsButton">Click to show/hide comments contents</button>
    <div class="forumDiv" id="comments">
        <table class="forumTable">
            <?php
            foreach ($result as $row) {
                if ($row['section'] == "comments") {
                    $counter++;//counting how much content there is for the section
                    echo "
                        <tr>
                            <th>By: <br>" . $row['user'] . "</th>
                            <td>
                                <span class='title'>" . $row['title'] . "<br></span>
                                Created: " . $row['date'] . "<BR>
                                
                                <div class='forumContentIndent'>
                                    " . $row['contents'] . "
                                </div>";
                    if(isset($_SERVER['uname'])) {
                        if (($_SESSION['uname'] == $row['user']) || ($_SESSION['accessLevel'] == 1)) {
                            echo "<a href='removeComment.php'>Delete</a>";
                        }
                        if ($_SESSION['uname'] == $row['user']) {
                            echo " | <a href='updateComment'>Modify</a>";
                        }
                    }
                             echo "</td>
                        </tr>";
                }
            }
        echo "</table>";
        if($counter == 0) {
            echo "There is no content available yet!";
        }
        $counter = 0;//reseting the counter
        echo "</div>";?>

    <br/>
    <br>

    <h4 class="forumTitle">Helpful Tips and Tricks</h4>
    <?php if(isset($_SESSION['uname'])) {
        echo "<form name='tipsPost' id='tipsPost' method='post' action='forum.php'>
        <input type='submit' name='tipsPost' id='tipsPost' value='Post a new tip or tricks!'>
        </form>";
    } ?>
    <button type="button" id="tipsButton">Click to show/hide tips and tricks contents</button>
    <div class="forumDiv" id="tips">
        <table class="forumTable">
            <?php
            foreach ($result as $row) {
                if ($row['section'] == "tips") {
                    $counter++;//counting how much content there is for the section
                    echo "
                        <tr>
                            <th>By: <br>" . $row['user'] . "</th>
                            <td>
                                <span class='title'>" . $row['title'] . "<br></span>
                                Created: " . $row['date'] . "<BR>
                                
                                <div class='forumContentIndent'>
                                    " . $row['contents'] . "
                                </div>";
                    if(isset($_SESSION['uname'])) {
                        if (($_SESSION['uname'] == $row['user']) || ($_SESSION['accessLevel'] == 1)) {
                            echo "<a href='removeComment.php'>Delete</a>";
                        }
                        if ($_SESSION['uname'] == $row['user']) {
                            echo " | <a href='updateComment'>Modify</a>";
                        }
                    }
                    echo "</td>
                        </tr>";
                }
            }
            echo "</table>";
            if($counter == 0) {
                echo "There is no content available yet!";
            }
            $counter = 0;//reseting the counter
            echo "</div>";?>
    <br/>
    <br>

    <h4 class="forumTitle">Suggestions</h4>
            <?php if(isset($_SESSION['uname'])) {
                echo "<form name='suggestionPost' id='suggestionPost' method='post' action='forum.php'>
                <input type='submit' name='suggestionPost' id='suggestionPost' value='Post a new suggestion!'>
                </form>";
            } ?>
    <button type="button" id="suggestionsButton">Click to show/hide suggestions contents</button>
    <div class="forumDiv" id="suggestions">
        <table class="forumTable">
            <?php
            foreach ($result as $row) {
                if ($row['section'] == "suggestions") {
                    $counter++;//counting how much content there is for the section
                    echo "
                        <tr>
                            <th>By: <br>" . $row['user'] . "</th>
                            <td>
                                <span class='title'>" . $row['title'] . "<br></span>
                                Created: " . $row['date'] . "<BR>
                                
                                <div class='forumContentIndent'>
                                    " . $row['contents'] . "
                                </div>";
                    if(isset($_SESSION['uname'])) {
                        if (($_SESSION['uname'] == $row['user']) || ($_SESSION['accessLevel'] == 1)) {
                            echo "<a href='removeComment.php'>Delete</a>";
                        }
                        if ($_SESSION['uname'] == $row['user']) {
                            echo " | <a href='updateComment'>Modify</a>";
                        }
                    }
                            echo "</td>
                        </tr>";
                }
            }
            echo "</table>";
            if($counter == 0) {
                echo "There is no content available yet!";
            }
            $counter = 0;//reseting the counter
            echo "</div>";?>

    <br/>
    <br/>
    <br/>
<?php } elseif ($showform == 1) { ?>
    <form name="bugForm" id="emailInfo" method="post" action="forum.php" >
        <table id="newBugTable">
            <tr>
                <th>Short title describing problem: </th>
                <td><input type="text" name="title" id="title" value="<?php if(isset($formfield['title'])){echo $formfield['title'];} ?>"/><span class="error"><br><?php echo $errortitle; ?></span></td>
            </tr>
            <tr>
                <th>Full Bug Description: </th>
                <td><textarea name="content" id="content" value="<?php if(isset($formfield['content'])){echo $formfield['content'];} ?>"></textarea><span class="error"><?php echo $errorcontent; ?></span></td>
            </tr>
            <tr>
                <td colspan="2" id="bugPostButtonTable"><input id="bugPostButton" type="submit" name="bugPostButton"/></td>
            </tr>
        </table>
    </form>

<?php } elseif ($showform == 2) { ?>
    <form name="commentForm" id="emailInfo" method="post" action="forum.php" >
        <table id="newBugTable">
            <tr>
                <th>Title: </th>
                <td><input type="text" name="title" id="title" value="<?php if(isset($formfield['title'])){echo $formfield['title'];} ?>"/><span class="error"><br><?php echo $errortitle; ?></span></td>
            </tr>
            <tr>
                <th>Content: </th>
                <td><textarea name="content" id="content" value="<?php if(isset($formfield['content'])){echo $formfield['content'];} ?>"></textarea><span class="error"><?php echo $errorcontent; ?></span></td>
            </tr>
            <tr>
                <td colspan="2" id="bugPostButtonTable"><input id="commentPostButton" type="submit" name="commentPostButton"/></td>
            </tr>
        </table>
        </form>
<?php } elseif ($showform == 3) {?>
<form name="tipForm" id="emailInfo" method="post" action="forum.php" >
        <table id="newBugTable">
            <tr>
                <th>Title: </th>
                <td><input type="text" name="title" id="title" value="<?php if(isset($formfield['title'])){echo $formfield['title'];} ?>"/><span class="error"><br><?php echo $errortitle; ?></span></td>
            </tr>
            <tr>
                <th>Content: </th>
                <td><textarea name="content" id="content" value="<?php if(isset($formfield['content'])){echo $formfield['content'];} ?>"></textarea><span class="error"><?php echo $errorcontent; ?></span></td>
            </tr>
            <tr>
                <td colspan="2" id="bugPostButtonTable"><input id="tipPostButton" type="submit" name="tipPostButton"/></td>
            </tr>
        </table>
        </form>
<?php } elseif($showform == 4) {?>
    <form name="suggestionForm" id="emailInfo" method="post" action="forum.php" >
        <table id="newBugTable">
            <tr>
                <th>Title: </th>
                <td><input type="text" name="title" id="title" value="<?php if(isset($formfield['title'])){echo $formfield['title'];} ?>"/><span class="error"><br><?php echo $errortitle; ?></span></td>
            </tr>
            <tr>
                <th>Content: </th>
                <td><textarea name="content" id="content" value="<?php if(isset($formfield['content'])){echo $formfield['content'];} ?>"></textarea><span class="error"><?php echo $errorcontent; ?></span></td>
            </tr>
            <tr>
                <td colspan="2" id="bugPostButtonTable"><input id="suggestionPostButton" type="submit" name="suggestionPostButton"/></td>
            </tr>
        </table>
    </form>
<?php } ?>






<h4>TODO</h4>
<ul>
    <li>Let users see everything accept the bug reporting section</li>
    <li>Require login to post</li>
    <li>All users can view</li>
    <li>Only Admins can delete</li>
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        $('#bugButton').on('click', function(){
            $('#bugs').toggle();
        });

        $('#commentsButton').on('click', function(){
            $('#comments').toggle();
        });

        $('#tipsButton').on('click', function(){
            $('#tips').toggle();
        });

        $('#suggestionsButton').on('click', function(){
            $('#suggestions').toggle();
        });

    });

</script>

<?php
require_once "footer.php"; ?>

