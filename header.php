<?php 
    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
        $loginState = false;
    } else {
        $loginState = true;
    }
?>

<header class="header">
    <h1 class="logo"><a href="index.php"><i class="fas fa-paw logo-icon"></i>iProBroad</a></h1>
    <nav class="nav-bar">
        <ul class="nav-list">
            <?php if($loginState === false){?>
                <li class="nav-item"><a href="login.php">Login</a></li>
            <?php } else {?>
                <li class="nav-item"><a href="admin.php?logout=true">Logout</a></li>
            <?php }?>
            <li class="nav-item"><a href="index.php">Browse</a></li>
            <li class="nav-item"><a href="post.php">Post</a></li>
        </ul>
    </nav>
</header>