<?php
require_once("db_connect.php");
require_once("function.php");

// ログイン状態でない場合ログインページへ飛ぶ
check_user_logget_in();

// 登録ボタンが押された場合
if (isset($_POST["entry"])) {
	$entry = $_POST["entry"];
	// タイトルの入力チェック
	if (empty($_POST["title"])) {
		echo "タイトルが未入力です。" . "<br>";
	// 発売日の入力チェック
	}
	if (empty($_POST["date"])) {
		echo "発売日が未入力です。" . "<br>";
	}
	// 在庫数の入力チェック
	if (empty($_POST["stock"])) {
		echo "在庫が未入力です。" . "<br>";
	}

	// タイトル、発売日、在庫数の入力OK
	if (!empty($_POST["title"]) && !empty($_POST["date"]) && !empty($_POST["stock"])) {
		// 入力した title date stock を格納
    	$title = htmlspecialchars($_POST["title"], ENT_QUOTES);
    	$date = htmlspecialchars($_POST["date"], ENT_QUOTES);
    	$stock = htmlspecialchars($_POST["stock"], ENT_QUOTES);
		// DBに接続
		$pdo = db_connect();
		// 本の新規登録
		try {
			$sql = "INSERT INTO books(title, date, stock) VALUES(:title, :date, :stock)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":title", $title);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":stock", $stock);
			$stmt->execute();
			header("Location: index.php");
			exit;
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}
	}
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta http-equiv="Contet-Type" content="text/html; charset=utf-8;">
	<title>本　登録画面</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">
	<!-- 本を登録してインデックスに表示 -->
	<form action="" method="post">
		<input type="text" name="title" id="title" placeholder="タイトル" value="<?php if (!empty($_POST["title"]) ){ echo $_POST["title"]; } ?>" class="text-box"><br>
		<input type="text" name="date" id="date" placeholder="発売日" value="<?php if (!empty($_POST["date"]) ){ echo $_POST["date"]; } ?>" class="text-box"><br>
		在庫数<br>
		<select name="stock" id="stock" value="<?php if (!empty($_POST["stock"]) ){ echo $_POST["stock"]; } ?>" class="stock-box">
		<option value="">選択してください</option>
		<!-- 在庫数を100まで表示 -->
			<?php for ($i=1; $i <= 100; $i++) { ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
			<?php } ?>
		</select><br>
		<input type="submit" name="entry" id="entry" value="登録" class="book-entry-button2">
	</form>
</body>
</html>