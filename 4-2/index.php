<?php
require_once("db_connect.php");
require_once("function.php");

// ログイン状態でない場合ログインページへ飛ぶ
check_user_logget_in();

// DBに接続
$pdo = db_connect();

// 登録された本を昇順で表示
try {
	$sql = "SELECT * FROM books ORDER BY date ASC";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(":title", $title);
	$stmt->bindParam(":date", $date);
	$stmt->bindParam(":stock", $stock);
	$stmt->execute();
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
	die();
}

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta http-equiv="Contet-Type" content="text/html; charset=utf-8;">
	<title>インデックス</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">
	<!-- 本の新規登録画面へ-->
	<form action="" method="post">
		<input type="submit" name="book_entry" value="新規登録" formaction="book_entry.php"
		class="book-entry-button">
	<!-- ログアウトしてログイン画面へ -->
		<input type="submit" name="logout" value="ログアウト" formaction="logout.php" class="logOut-button">
	</form>
	<table>
		<th>タイトル</th>
		<th>発売日</th>
		<th>在庫数</th>
		<th></th>
		<tr>
			<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
			<td><?php echo $row["title"]; ?></td>
			<td><?php echo date("Y/m/d", strtotime($row["date"]));
			 ?></td>
			<td><?php echo $row["stock"];
			 ?></td>
			<td>
				<!-- 削除ボタン -->
				<form action="book_delete.php" method="post">
							<a href="book_delete.php?id=<?php echo $row["id"]; ?>"><input type="button" name="delete" id="delete" value="削除" formaction="" class="delete-button"></a>
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>