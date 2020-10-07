<?php
require_once("db_connect.php");

if (!empty($_POST)) {
	// ログイン名が未入力の場合
	if (empty($_POST["name"])) {
		echo "名前が未入力です。" . "<br>";
	}
	// パスワードが未入力の場合
	if (empty($_POST["password"])) {
		echo "パスワードが未入力です。" . "<br>";
	}

	// ログイン名、パスワード共に入力OK
	if (isset($_POST['signUp'])) {
		$signUp = $_POST['signUp'];
		if ($_POST['name'] && $_POST['password']) {
			$name = $_POST['name'];
			$password = $_POST['password'];

			// DBに接続
			$pdo = db_connect();
			// 新規登録
			try {
				$sql = "INSERT INTO users (name, password) VALUES(:name, :password)";
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':password', $password_hash);
				$stmt->execute();
				echo "登録を完了しました。";
			} catch (PDOException $e) {
				echo 'Error: ' . $e->getMessage();
				die();
			}
		}
	}
}
 ?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html:charset=UTF-8">
	<title>新規ユーザー登録</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="wrapper">
		<form action="" method="post">
			<input type="text" name="name" placeholder="ユーザー名" class="text-box"><br>
			<input type="password" name="password" placeholder="パスワード" class="text-box"><br>
			<input type="submit" name="signUp" value="新規登録" class="signUp-button2">
		</form>
		<a href="login.php">戻る</a>
</body>
</html>