<?php 
    session_start();

    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        header("Location: login.php");
    }

    require_once("db_connect.php");	

    if(isset($_POST["action"])&&($_POST["action"]=="delete")){	
        $sql_query = "DELETE FROM board WHERE boardid=?";
        $stmt=$db_link->prepare($sql_query);
        $stmt->bind_param("i",$_POST["authorId"]);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php");
    }

    $query_RecBoard = "SELECT boardid, boardname, boardsex, boardsubject, boardmail, boardweb, boardcontent FROM board WHERE boardid=?";
    $stmt=$db_link->prepare($query_RecBoard);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $stmt->bind_result($boardid, $boardname, $boardsex, $boardsubject, $boardmail, $boardweb, $boardcontent);
    $stmt->fetch();
    $stmt->close();

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iProBoard</title>
    <link rel="stylesheet" href="css/reset.css">
    <link href="css/main.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d14ba3f31b.js" crossorigin="anonymous"></script>
    <script src="js/main.js" defer></script>
</head>

<body>
    <?php require('header.php'); ?>
    <main class="main">
        <form class="message-sender for-delete" action="" method="POST" enctype="multipart/form-data">
            <div class="author-info-sender">
                <div class="input-handler">
                    <label for="authorName">Your Name</label>
                    <span class="info-shower"><?php echo $boardname;?></span>
                </div>
                <div class="input-handler gender for-show">
                    <span>Your Gender</span>
                    <span class="info-shower"><?php echo $boardsex;?></span>
                </div>
                <div class="input-handler">
                    <label for="messageTitle">Message Title</label>
                    <span class="info-shower"><?php echo $boardsubject;?></span>
                </div>
                <div class="input-handler">
                    <label for="authorMail">Your Email</label>
                    <span class="info-shower"><?php echo $boardmail;?></span>
                </div>
                <div class="input-handler">
                    <label for="authorSite">Your site</label>
                    <span class="info-shower"><?php echo $boardweb;?></span>
                </div>
            </div>
            <div class="message-content-sender">
                <textarea class="messageContent" name="messageContent" id="messageContent"
                    placeholder="Enter your content here" disabled><?php echo $boardcontent;?></textarea>
            </div>
            <div class="sender-buttons">
                <input name="authorId" type="hidden" id="authorId" value="<?php echo $boardid;?>">
                <input type="hidden" name="action" value="delete">
                <input type="submit" value="delete">
                <input type="button" value="back">
            </div>
        </form>
    </main>
    <?php require('footer.html'); ?>
</body>

</html>