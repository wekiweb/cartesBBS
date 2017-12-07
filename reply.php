<?php
include "common.php";
$pagetitle = "Reply to";

include $path."db_info.php";

$query = "SELECT * FROM $board WHERE id='$_GET[id]'";
$parent_result = mysqli_query($conn, $query);
$parent_row = mysqli_fetch_array($parent_result);
$parent_title = "RE: ".$parent_row['title'];
$parent_content = "\n&gt;".str_replace("\n", "\n&gt;", $parent_row['content']);
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
<form action="<?=$path?>insert_reply.php" method="post">
<input type="hidden" name="parent_depth" value="<?=$parent_row['depth']?>">
<input type="hidden" name="parent_thread" value="<?=$parent_row['thread']?>">
<dl>
    <dt><label for="name">Author</label></dt>
    <dd>
        <input type="text" name="name" id="name" size="20" maxlength="10">
    </dd>
    <dt><label for="passwd">Password</label></dt>
    <dd>
        <span class="warning">
            Enter a temporary password.<br>
            (needed later for editing/deleting this post)
        </span><br>
        <input type="password" name="passwd" id="passwd" size="8" maxlength="8">
    </dd>
    <dt><label for="email">E-mail</label></dt>
    <dd>
        <input type="text" name="email" id="email" size="20" maxlength="25">
    </dd>
    <dt><label for="title">Title</label></dt>
    <dd>
        <input type="text" name="title" id="title" size="60" maxlength="35" value="<?=$parent_title?>">
    </dd>
    <dt><label for="content">Content</label></dt>
    <dd>
        <textarea name="content" id="content" cols="65" rows="15"><?=$parent_content?></textarea>
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
