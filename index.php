<?php
    session_start();
    require_once("db_connect.php");

    if(isset($_SESSION["loginMember"])){
        header("Location: admin.php");
    }

    $pageRow_records = 5;
    $num_pages = 1;

    if (isset($_GET['page'])) {
        $num_pages = $_GET['page'];
    }

    $startRow_records = ($num_pages -1) * $pageRow_records;
    $query_RecBoard = "SELECT * FROM board ORDER BY boardtime DESC";
    $query_limit_RecBoard = $query_RecBoard." LIMIT {$startRow_records}, {$pageRow_records}";

    $RecBoard = $db_link->query($query_limit_RecBoard); //get 5 records
    $all_RecBoard = $db_link->query($query_RecBoard); // get all records

    $total_records = $all_RecBoard->num_rows;
    $total_pages = ceil($total_records/$pageRow_records);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iProBoard</title>
    <link rel="stylesheet" href="css/reset.css">
    <link href="css/main.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="css/main.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d14ba3f31b.js" crossorigin="anonymous"></script>
    <script src="js/main.js" defer></script>
</head>

<body>
    <?php require('header.php'); ?>
    <main class="main">

        <?php while($row_RecBoard=$RecBoard->fetch_assoc()){?>
        <div class="author-info">
            <img class="avatar" src="images/<?= $row_RecBoard["boardimage"]?>" alt="avatar">
            <p class="author-name"><?= $row_RecBoard["boardname"]?><span
                    class="gender"><?=$row_RecBoard["boardsex"]?></span></p>
        </div>
        <div class="message-display-area"><p class="contentTitle"><?= $row_RecBoard["boardsubject"]?></p><p><?= $row_RecBoard["boardcontent"]?></p></div>
        <div class="message-info clearfix">
            <p><span class="posted-time" title="date"><?= $row_RecBoard["boardtime"]?></span> |
                <?php if($row_RecBoard["boardmail"]!==''){?><a href="mailto:<?= $row_RecBoard["boardmail"]?>" title="email"><i
                        class="fas fa-envelope"></i></a><?php }?><?php if($row_RecBoard["boardweb"]!==''){?> | <a
                    href="<?=$row_RecBoard["boardweb"]?>" title="website"><i class="fab fa-staylinked"></i></a><?php }?>
            </p>
        </div>
        <?php } ?>
        <div class="page-info clearfix">
            <span class="total-num">Total: <?= $total_records?></span>
            <div class="page-nav">
                <?php if ($num_pages > 1) {?>
                <a href="?page=1">FirstPage</a> | <a href="?page=<?php echo $num_pages-1;?>">PrevPage</a>
                <?php }?>
                <?php if ($num_pages < $total_pages) {?>
                <a href="?page=<?php echo $num_pages+1;?>">NextPage</a> | <a
                    href="?page=<?php echo $total_pages;?>">LastPage</a>
                <?php }?>
            </div>
        </div>
    </main>
    <?php require('footer.html'); ?>
</body>

</html>
<?php
	$db_link->close();
?>