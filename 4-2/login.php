<?php
require_once("db_connect.php");

//セッション開始
session_start();

if (!empty($_POST)) {
	//ログイン名が未入力
	if (empty($_POST["name"])) {
		echo "名前が未入力です。" . "<br>";
	}
	//パスワードが未入力
	if (empty($_POST["password"])) {
		echo "パスワードが未入力です。" . "<br>";
	}
	//ログイン名、パスワード共に入力OK
	if (!empty($_POST["name"]) && !empty($_POST["password"])) {
		$name = htmlspecialchars($_POST["name"], ENT_QUOTES);
		$password = htmlspecialchars($_POST["password"], ENT_QUOTES);
		$pdo = db_connect();

		try {
			//DBにログイン名があるかどうか確認
			$sql = "SELECT * FROM users WHERE name = :name";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":name", $name);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
			die();
		}

		//結果が１行取得できたら
		if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//
			//
			if (password_verify($password, $row["password"])) {
				//
				$_SESSION["id"] = $row["id"];
				$_SESSION["name"] = $row["name"];
				//
				header("Location: index.php");
				exit;
			} else {
				//
				echo "パスワードに誤りがあります。";
			}
		} else {
			//
			echo "ユーザー名かパスワードに誤りがあります";
		}
	}
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>ログイン</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="wrapper clearfix">
	<!-- 新規登録ページへ -->
	<a href="signUp.php"><input type="button" name="signUp" value="新規ユーザー登録" class="signUp-button"></a>
	<!-- 入力欄 -->
	<form action="" method="post">
		<input type="text" name="name" placeholder="ユーザー名" class="text-box"><br>
		<input type="password" name="password" placeholder="パスワード" class="text-box"><br>
		<input type="submit" name="login" value="ログイン" class="login-button">
	</form>
</body>
</html>