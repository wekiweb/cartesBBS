<?php
include "common.php";
$pagetitle = "Delete Post";

include $path."db_info.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$pagetitle?> :: <?=$sitetitle?></title>

<link rel="stylesheet" type="text/css" href="<?=$path?>style.css" />
</head>
<body>
<h1>Password Confirm before Deleting</h1>
<form action="del.php?id=<?=$_GET['id']?>" method="post">
<dl>
    <dt>Password</dt>
    <dd>
        <input type="password" name="passwd" size="8">
        <input type="submit" value="Confirm">
        <input type="button" value="Cancel" onclick="history.back(-1)">
    </dd>
</dl>
</form>
</body>
</html>
