<?php
// db_connect.phpの読み込み
require_once('db_connect.php');
// function.phpの読み込み
require_once('function.php');
// ログインしていなければ、login.phpにリダイレクト
check_user_logged_in();

// URLの?以降で渡されるIDをキャッチ
$id = $_GET['id'];

// もし、$idが空であったらmain.phpにリダイレクト
// 不正なアクセス対策
redirect_main_unless_paramater($id);

// 引数で与えられたidでpostsテーブルを検索する
// もし対象のレコードがなければmain.phpに遷移させる
$row = find_post_by_id($id);

$id = $row['id'];
$title = $row['title'];
$content = $row['content'];

// PDOのインスタンスを取得
$pdo_commtents = db_connect();

try {
	// SQL文の準備
	$sql_comments = 'SELECT * FROM comments WHERE post_id = :post_id';
	// プリペアドステートメントの作成
	$stmt_commtents = $pdo_commtents->prepare($sql_comments);
	// idのバインド
	$stmt_commtents->bindParam(':post_id', $id);
	$stmt_commtents->execute();
} catch (PDOException $e) {
	// エラーメッセージの出力
	echo 'Error: ' . $e->getMessage();
	// 終了
	die();
}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>記事詳細</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<table>
			<tr>
				<td>ID</td>
				<td><?php echo $id; ?></td>
			</tr>
			<tr>
				<td>タイトル</td>
				<td><?php echo $title; ?></td>
			</tr>
			<tr>
				<td>本文</td>
				<td><?php echo $content; ?></td>
			</tr>
		</table>
		<a href="create_comment.php?post_id=<?php echo $id ?>">この記事にコメントする</a>
		<a href="main.php">メインページに戻る</a>
		<div>
			<?php 
			while ($row = $stmt_commtents->fetch(PDO::FETCH_ASSOC)) {
				echo '<hr>';
				echo $row['name'];
				echo '<br/>';
				echo $row['content'];
			 }
			?>
		</div>
	</body>
</html>