<?php
include "common.php";

include $path."db_info.php";

$result = mysqli_query($conn, "SELECT passwd FROM $board WHERE id=$_GET[id]");
$row = mysqli_fetch_array($result);

if ($_POST['passwd'] == $row['passwd'])
{
    $query = "DELETE FROM $board WHERE id=$_GET[id]";
    $result = mysqli_query($conn, $query);

    $success = true;
}
else
{
echo <<<EOT
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
    alert("Succesfully deleted!");
    location.href="<?=$path?>list.php";
}
</script>
