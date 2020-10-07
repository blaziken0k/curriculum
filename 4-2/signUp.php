<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// POSTで送られていれば処理実行
if (isset($_POST['signUp'])) {
	$signUp = $_POST['signUp'];
// nameとpassword両方送られてきたら処理実行
	if ($_POST['name'] && $_POST['password']) {
		$name = $_POST['name'];
		$password = $_POST['password'];

		// PDOのインスタンスを取得
		$pdo = db_connect();

		try {
				// SQL文の準備
				$sql = "INSERT INTO users (name, password) VALUES(:name, :password)";
				// パスワードをハッシュ化
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				// プリペアドステートメントの作成
				$stmt = $pdo->prepare($sql);
				// 値をセット
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':password', $password_hash);
				// 実行
				$stmt->execute();
				//　登録完了メッセージ出力
				echo "登録を完了しました。";
			} catch (PDOException $e) {
				// エラーメッセージの出力
				echo 'Error: ' . $e->getMessage();
				// 終了
				die();
			}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<h1>新規登録</h1>
		<form method="POST" action="">
			user:<br>
			<input type="text" name="name" id="name">
			<br>
			password:<br>
			<input type="password" name="password" id="password"><br>
			<input type="submit" value="submit" id="signUp" name="signUp">
		</form>
	</body>
</html>

