<?php
include "common.php";
$pagetitle = "List";

include $path."db_info.php";

// 1. 한 페이지에 보여질 게시물의 수
$page_size = 10;

// 2. 페이지나누기에 표시될 페이지의 수
$page_list_size = 10;

// $no값이 안넘어오거나 잘못된(음수)값이 넘어오는 경우 0으로 처리
if (!isset($_GET['no']) || $_GET['no'] < 0)
    $no = 0;
else
    $no = $_GET['no'];

// DB에서 페이지의 첫 번째 글($no)부터 $page_size만큼의 글을 가져온다.
$query = "SELECT * FROM $board ORDER BY thread DESC LIMIT $no, $page_size";
$result = mysqli_query($conn, $query);

// 총 게시물 수를 구한다.
// count를 통해 구할 수 있는데 count(항목)과 같은 방법으로 사용한다.
// *는 모든 항목을 뜻한다.
// 총 해당 항목의 값을 가지는 게시물의 개수가 얼마인가를 묻는 것이다.
// 따라서 전체 글 수가 된다. count(id)와 같은 방법도 가능하지만,
// 이례적으로 count(*)가 조금 빠르다. 일반적으로는 *가 느리다.
$result_count = mysqli_query($conn, "SELECT count(*) FROM $board");
$result_row = mysqli_fetch_row($result_count);
$total_row = $result_row[0];
// 결과의 첫번째 열이 count(*)의 결과다.

// 총 페이지 계산
if ($total_row <= 0) // 총 게시물의 값이 없을 경우 기본값으로 세팅
    $total_row = 0;

// 총 게시물에 1을 뺀뒤에 페이지 사이즈로 나누고 소수점 이하를 버린다.

$total_page = floor(($total_row - 1) / $page_size);
// 총 페이지는 총 게시물의 수를 $page_size로 나누면 알 수 있다.
// 총 게시물이 12개(1을 빼서 11이 된다)이고 페이지 사이즈가 10이라면 결과는 1.1이 나올 것이다.
// 1.1라는 페이지수는 한 페이지를 다 표시하고도 글이 더 남아있다는 뜻이다.
// 따라서 실제의 페이지 수는 2가 된다. 한 페이지는 2개의 글만 표시될 것이다.
// 그러나 내림을 해주는 이유는 페이지 수가 0부터 시작하기 때문이다. 따라서 1은 두번째 페이지다.
// 총 게시물에 1을 빼주는 이유는 10페이지가 되면 10/10 = 1이기 때문이다.
// 앞에서도 말했지만 1은 2번째 페이지를 뜻한다.
// 그러나 총게시물이 10개인 경우 한 페이지에 모두 출력되어야 한다.
// 그래서 1을 빼서 10개인 경우 (10-1) / 10 = 0.9로 한 페이지에 출력한다.
// 글이 0개가 있는 경우 결과가 -1이 되지만 -1은 무시된다.
// (floor()는 내림을 하는 수학함수이다.)

$current_page = floor($no/$page_size);
// $no을 통해서 페이지의 첫번째 글이 몇 번째 글인지 전달된다.
// 따라서 페이지 사이즈로 나누면 현재가 몇 번째 페이지인지 알 수 있다.
// $no이 10이고 페이지 사이즈가 10이라면 결과는 1이다. 앞서 페이지는 0부터
// 시작이라고 했으니 두번째 페이지임을 나타낸다.
// 그렇다면 $no이 11이라면 1.1이 되어 버린다. 11번째 글도 두번째 페이지에 존재하므로 0.1은 무의미하니 버린다.
// 그런데 $no이란 값이 $page_size만큼씩 증가되는 값이기 때문에(0, 10, 20, 30과 같은 등차수열)
// 내림을 하는 것 또한 무의미하다.
// 그러나 내림을 하는 이유는 $no값에 11과 같은 값이 들어와도 제대로 출력되기를 바라는 마음에서 해놓은 것이다.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?=$charset?>">
    <title><?=$pagetitle?> :: <?=$sitetitle?></title>

<link rel="stylesheet" type="text/css" href="<?=$path?>style.css" />
</head>
<body class="page-list">
<div id="wrap">
<h1><?=$pagetitle?> :: <?=$sitetitle?></h1>
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
} // end of while($row=mysql_fetch_array($result))

mysqli_close($conn);
?>
</table>
<p class="pagination">
<?php
$start_page = (int)($current_page / $page_list_size) * $page_list_size;

$end_page = $start_page + $page_list_size - 1;
if ($total_page < $end_page)
    $end_page = $total_page;

if ($start_page >= $page_list_size) {
    $prev_list = ($start_page - 1)*$page_size;
    echo "<a href=\"$_SERVER[PHP_SELF]?no=$prev_list\">◀</a>\n";
}

for ($i=$start_page; $i<=$end_page;$i++) {
    $page=$page_size*$i;
    $page_num = $i+1;

    if ($no!=$page)
        echo "<a href=\"$_SERVER[PHP_SELF]?no=$page\">";

    echo " $page_num ";

    if ($no!=$page)
        echo "</a>";
}

if ($total_page > $end_page) {
    $next_list = ($end_page + 1) * $page_size;
    echo "<a href=\"$_SERVER[PHP_SELF]?no=$next_list\">▶</a>";
}
?>
</p>
<p>
<a href="<?=$path?>compose.php">[Post New]</a>
</p>
</div>
</body>
</html>
