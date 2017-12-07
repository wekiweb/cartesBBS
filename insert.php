<?php
include "common.php";

include $path."db_info.php";

// get the value of max_thread
$query = "SELECT max(thread) FROM $board";
$max_thread_result = mysqli_query($conn, $query);
$max_thread_fetch = mysqli_fetch_row($max_thread_result);
$max_thread = ceil($max_thread_fetch[0]/1000)*1000 + 1000;

$query = "INSERT INTO $board (thread, depth, name, passwd, email, title, hits, wdate, ip, content) ";
$query.= "VALUES ($max_thread, 0, '$_POST[name]', '$_POST[passwd]', '$_POST[email]', '$_POST[title]', 0, UNIX_TIMESTAMP(), '$_SERVER[REMOTE_ADDR]', '$_POST[content]')";
$result = mysqli_query($conn, $query);

// mysql connection close
mysqli_close($conn);

$success = true;
?>
<script>
if(<?=$success?>) {
    alert("Successfully submitted!");
    location.href="<?=$path?>list.php";
}
</script>
