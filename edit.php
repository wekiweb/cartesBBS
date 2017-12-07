<?php
include "common.php";
$pagetitle = "Edit Post";

include $path."db_info.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?=$charset?>">
    <title><?=$pagetitle?> :: <?=$sitetitle?></title>

<link rel="stylesheet" type="text/css" href="<?=$path?>style.css" />
</head>

<body>
<h1><?=$pagetitle?> :: <?=$sitetitle?></h1>
<form action="<?=$path?>update.php?id=<?=$_GET['id']?>" method="post">
<?php
$result = mysqli_query($conn, "SELECT * FROM $board WHERE id=$_GET[id]");
$row = mysqli_fetch_array($result);
?>
<dl>
    <dt><label for="name">Author</label></dt>
    <dd>
        <input type="text" name="name" id="name" size="20" maxlength="10" value="<?=$row['name']?>">
    </dd>
    <dt><label for="passwd">Password</label></dt>
    <dd>
        <span class="warning">The password must be correct in order to edit this posting.</span><br>
        <input type="password" name="passwd" id="passwd" size="8" maxlength="8">
    </dd>
    <dt><label for="email">E-Mail</label></dt>
    <dd>
        <input type="text" name="email" id="email" size="20" maxlength="25" value="<?=$row['email']?>">
    </dd>
    <dt><label for="title">Title</label></dt>
    <dd>
        <input type="text" name="title" id="title" size="60" maxlength="35" value="<?=$row['title']?>">
    </dd>
    <dt><label for="content">Content</label></dt>
    <dd>
        <textarea name="content" id="content" cols="65" rows="15"><?=$row['content']?></textarea>
    </dd>
</dl>
<p>
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
    <input type="button" value="Go Back" onclick="history.back(-1)">
</p>
</form>
</body>
</html>
