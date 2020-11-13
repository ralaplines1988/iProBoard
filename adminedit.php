<?php 
    session_start();

    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        header("Location: login.php");
    }
    
    function GetSQLValueString($theValue, $theType) {
        switch ($theType) {
        case "string":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
            break;
        case "int":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
            break;
        case "email":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
            break;
        case "url":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_URL) : "";
            break;      
        }
        return $theValue;
    }

    require_once("db_connect.php");	

    $query_RecBoard = "SELECT boardid, boardname, boardsex, boardsubject, boardmail, boardweb, boardcontent, boardimage FROM board WHERE boardid=?";
    $stmt=$db_link->prepare($query_RecBoard);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $stmt->bind_result($boardid, $boardname, $boardsex, $boardsubject, $boardmail, $boardweb, $boardcontent, $boardimage);
    $stmt->fetch();
    $stmt->close();

    if(isset($_POST["action"])&&($_POST["action"]=="update")){
        require_once("db_connect.php");	
        if($_FILES['authorAvatar']['name'] === ''){
            $_POST['authorAvatar'] = $boardimage;
            echo $_POST['authorAvatar'];
        } else {
            $imageType = substr($_FILES['authorAvatar']['type'],6);
            $imageName = substr($_FILES['authorAvatar']['name'],0,5);
            if($_FILES['authorAvatar']['error'] === 0){
                if(move_uploaded_file($_FILES['authorAvatar']['tmp_name'],"./images/user-{$_POST['authorName']}$imageName.$imageType"));
                $_POST['authorAvatar'] = "user-{$_POST['authorName']}$imageName.$imageType";
            }
        }

        $query_update = "UPDATE board SET boardname=?, boardsex=?, boardsubject=?, boardmail=?, boardweb=?, boardcontent=?,boardimage=? WHERE boardid=?";
        $stmt = $db_link->prepare($query_update);
        $stmt->bind_param("sssssssi",
            GetSQLValueString($_POST["authorName"], "string"),
            GetSQLValueString($_POST["authorGender"], "string"),
            GetSQLValueString($_POST["messageTitle"], "string"),
            GetSQLValueString($_POST["authorMail"], "email"),
            GetSQLValueString($_POST["authorSite"], "url"),
            GetSQLValueString($_POST["messageContent"], "string"),
            $_POST['authorAvatar'],
            GetSQLValueString($_POST["authorId"], "int"));		
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php");
    }
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
        <form class="message-sender" action="" method="POST" enctype="multipart/form-data" id="formPost">
            <div class="author-info-sender">
                <div class="input-handler">
                    <label for="authorName">Your Name</label>
                    <input type="text" id="authorName" name="authorName" value="<?php echo $boardname;?>">
                </div>
                <div class="input-handler gender">
                    <p>Your Gender</p>
                    <input type="radio" id="gender-male" name="authorGender" value="male" <?php if($boardsex === 'male'){echo 'checked';}?>>
                    <label for="gender-male">Male</label>
                    <input type="radio" id="gender-female" name="authorGender" value="female" <?php if($boardsex === 'female'){echo 'checked';}?>>
                    <label for="gender-female">Female</label>
                </div>
                <div class="input-handler">
                    <label for="authorAvatar">Avatar</label>
                    <input type="file" id="authorAvatar" name="authorAvatar">
                </div>
                <div class="input-handler">
                    <label for="messageTitle">Message Title</label>
                    <input type="text" id="messageTitle" name="messageTitle" value="<?php echo $boardsubject;?>">
                </div>
                <div class="input-handler">
                    <label for="authorMail">Your Email</label>
                    <input type="text" id="authorMail" name="authorMail" value="<?php echo $boardmail;?>">
                </div>
                <div class="input-handler">
                    <label for="authorSite">Your site</label>
                    <input type="text" id="authorSite" name="authorSite" value="<?php echo $boardweb;?>">
                </div>
            </div>
            <div class="message-content-sender">
                <textarea class="messageContent" name="messageContent" id="messageContent"
                    placeholder="Enter your content here"><?php echo $boardcontent;?></textarea>
            </div>
            <div class="sender-buttons">
                <input name="authorId" type="hidden" id="authorId" value="<?php echo $boardid;?>">
                <input type="hidden" name="action"value="update">
                <input type="submit" value="send">
                <input type="button" value="back">
            </div>
        </form>
    </main>
    <?php require('footer.html'); ?>
</body>
</html>
<?php
	$db_link->close();
?>