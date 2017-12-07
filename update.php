<?php
include "common.php";

include $path."db_info.php";

$query = "SELECT passwd FROM $board WHERE id=$_GET[id]";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($_POST['passwd'] == $row['passwd'])
{
    $query = "UPDATE $board SET name='$_POST[name]', email='$_POST[email]', title='$_POST[title]', content='$_POST[content]' WHERE id=$_GET[id]";
    $result = mysqli_query($conn, $query);

    $success = true;
}
else
{
echo<<<EOT
<script>
alert("Wrong Password!");
history.go(-1);
</script>
EOT;
exit;
}
?>
<script>
if(<?=$success?>) {
    alert("Succesfully edited!");
    location.href="<?=$path?>list.php";
}
</script>
