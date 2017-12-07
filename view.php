<?php
include "common.php";
$pagetitle = "View Post";

include $path."db_info.php";

$id=$_GET['id'];
if (!isset($_GET['no']) || $_GET['no'] < 0)
    $no = 0;
else
    $no = $_GET['no'];

// 조회수 업데이트
$query = "UPDATE $board SET hits=hits+1 WHERE id=$id";
$result = mysqli_query($conn, $query);

// 글 정보 가져오기
$query = "SELECT * FROM $board WHERE id=$id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$pagetitle?> :: <?=$sitetitle?></title>

<link rel="stylesheet" type="text/css" href="<?=$path?>style.css" />
</head>
<body class="page-view">
<div id="wrap">
<h1><?=$pagetitle?> :: <?=$sitetitle?></h1>
<dl>
    <dt>Author</dt>
    <dd><?=$row['name']?></dd>

    <dt>E-Mail</dt>
    <dd><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a>&nbsp;</dd>

    <dt>Date</dt>
    <dd><?=date("Y-m-d", $row['wdate'])?></dd>

    <dt>Views</dt>
    <dd><?=$row['hits']?></dd>
</dl>
<h2><?=strip_tags($row['title'])?></h2>
<pre><?=strip_tags($row['content'])?></pre>

<p>
<a href="<?=$path?>list.php?no=<?=$no?>">[List]</a>
<a href="<?=$path?>reply.php?id=<?=$id?>">[Reply]</a>
<a href="<?=$path?>compose.php">[Post New]</a>
<a href="<?=$path?>edit.php?id=<?=$id?>">[Edit]</a>
<a href="<?=$path?>pre_del.php?id=<?=$id?>">[Delete]</a>
</p>

<table class="list">
<?php
$query = "SELECT id, name, title FROM $board WHERE thread > $row[thread] ORDER BY thread ASC LIMIT 1";
$result = mysqli_query($conn, $query);
$up_id = mysqli_fetch_array($result);

if ($up_id['id']) // 이전 글이 있는 경우
{
    echo<<<EOT
<tr>
    <td class="title"><a href="{$path}view.php?id=$up_id[id]">△ $up_id[title]</a></td>
    <td class="name">$up_id[name]</td>
</tr>
EOT;
}

$query = "SELECT id, name, title FROM $board WHERE thread < $row[thread] ORDER BY thread DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$down_id = mysqli_fetch_array($result);

if ($down_id['id'])
{
    echo<<<EOT
<tr>
    <td class="title"><a href="{$path}view.php?id=$down_id[id]">▽ $down_id[title]</a></td>
    <td class="name">$down_id[name]</td>
</tr>
EOT;
}
?>
</table>

<?php
$thread_end = ceil($row['thread']/1000)*1000;
$thread_start = $thread_end - 1000;

$query = "SELECT * FROM $board WHERE thread <= $thread_end and thread > $thread_start ORDER BY thread DESC";
$result = mysqli_query($conn, $query);
($result);
?>
<table class="list">
    <tr>
        <th>No.</th><th>Title</th><th>Author</th><th>Date</th><th>Views</th>
    </tr>
<?php
while($row=mysqli_fetch_array($result))
{
?>
    <tr>
        <td class="no">
            <?=$row['id']?>
        </td>
        <td class="title">
            <span style="margin-left: <?php if ($row['depth'] > 0) echo $row['depth']*7;?>px;">
                <?php if ($row['depth'] > 0) echo "└ ";?><a href="<?=$path?>view.php?id=<?=$row['id']?>&amp;no=<?=$no?>"><?=strip_tags($row['title'], '<b><i>');?></a>
            </span>
        </td>
        <td class="author">
            <a href="mailto:<?=$row['email']?>"><?=$row['name']?></a>
        </td>
        <td class="date">
            <span><?=date("Y-m-d", $row['wdate'])?></span>
        </td>
        <td class="views">
            <span><?=$row['hits']?></span>
        </td>
    </tr>
<?php
} // end of while()
mysqli_close($conn);
?>
</table>
</div>
</body>
</html>
