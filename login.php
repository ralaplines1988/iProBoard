<?php
    session_start();

    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        if(isset($_POST["userName"]) && isset($_POST["userPwd"])){
            require_once("db_connect.php");	

            $sql_query = "SELECT * FROM admin where username = '{$_POST["userName"]}'";
            $result = $db_link->query($sql_query);		

            if($result->num_rows === 0){
                $tipInfo = 'Sorry, the admin account does not exist.';
            } else {
                $row_result=$result->fetch_assoc();
                $userName = $row_result["username"];
                $userPwd = $row_result["passwd"];
                $db_link->close();
                if(($userName===$_POST["userName"]) && ($userPwd===$_POST["userPwd"])){
                    $_SESSION["loginMember"]=$userName;
                    header("Location: admin.php");
                } else if($userName===$_POST["userName"]){
                    $tipInfo =  'Password not match, please try again!';
                }
            }
        }
    }else{
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
        <h2 class="login-title">LOGIN</h2>
        <span class="tip-info"><?php if(isset($tipInfo)){echo $tipInfo;}else{echo 'Hi! Welcome back!';} ?></span>
        <form action="" method="POST">
            <div class="user-info-sender">
                <label for="userName">UserName</label><br>
                <input type="text" id="userName" name="userName">
                <label for="userPwd">Password</label><br>
                <input type="password" id="userPwd" name="userPwd">
            </div>
            <div class="sender-buttons">
                <input type="submit" value="send">
                <input type="button" value="back">
            </div>
        </form>
    </main>
    <?php require('footer.html'); ?>
</body>

</html>