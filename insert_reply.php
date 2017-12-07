<?php
include "common.php";

include $path."db_info.php";

$prev_parent_thread = ceil($_POST['parent_thread']/1000)*1000 - 1000;

// 원본 글보다는 작고 위값보다는 큰 글들의 thread값을 모두 1씩 낮춘다.
$query = "UPDATE $board SET thread=thread-1 WHERE thread > $prev_parent_thread and thread < $_POST[parent_thread]";
$update_thread = mysqli_query($conn, $query);

// 원본 글보다는 1 작은 값으로 답글을 등록한다.
// 원본 글의 바로 밑에 등록된다.
// depth는 원본 글의 depth + 1이다. 원본 글이 3(이 글도 답글이군)이면 답글은 4가 된다.
$query = "INSERT INTO $board (thread, depth, name, passwd, email, title, hits, wdate, ip, content) ";
$query.= "VALUES ('".($_POST['parent_thread']-1)."'";
$query.= ",'".($_POST['parent_depth']+1)."','$_POST[name]','$_POST[passwd]','$_POST[email]','$_POST[title]', 0, UNIX_TIMESTAMP(), '$_SERVER[REMOTE_ADDR]','$_POST[content]')";
$result = mysqli_query($conn, $query);

// 데이터베이스와의 연결 종료
mysqli_close($conn);

$success = true;
?>
<script>
if(<?=$success?>) {
    alert("Successfully submitted!");
    //location.href="<?=$path?>list.php";
}
</script>
