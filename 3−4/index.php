<?php
require_once('getData.php');

// getData内のクラスを呼び出し
$ins = new getData();
// ユーザ情報の取得
$getuserdata = $ins -> getUserData();
// 記事情報の取得
$getpostdata = $ins -> getPostData();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="wrapper" class="clearfix">
			<!-- ヘッダー -->
			<div class="header-yilogo">
				<img src="logo.png" alt="yilogo" class="yilogo-img">
			</div>
			<div class="header-hello">
				<div class="header-text">
					ようこそ<?php echo $getuserdata['last_name'] . $getuserdata['first_name']; ?>さん
				</div>
			</div>
			<div class="header-day">
				<div class="header-text">
				最終ログイン日：<?php echo $getuserdata['last_login']; ?>
				</div>
			</div>
			<!-- メインコンテンツ -->
			<table>
				<tr>
					<th>記事ID</th>
					<th>タイトル</th>
					<th>カテゴリ</th>
					<th>本文</th>
					<th>投稿日</th>
				</tr>
				<!-- DB内全ての記事情報を取得して表示 -->
				<?php while ($row = $getpostdata->fetch(PDO::FETCH_ASSOC)) { ?>
					<tr>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['title']; ?></td>
						<td>
							<?php if ($row['category_no'] == 1) {echo "食事";
							} elseif ($row['category_no'] == 2) {
								echo "旅行";
							} else {
								echo "その他";
							}?>
						</td>
						<td><?php echo $row['comment']; ?></td>
						<td><?php echo $row['created']; ?></td>
					</tr>
				<?php } ?>
			</table>
			<!-- フッター -->
			<div class="footer">Y&I group.inc</div>
		</div>
	</body>
</html>