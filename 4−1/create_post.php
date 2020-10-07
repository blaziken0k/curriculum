<?php
// db_connect.phpの読み込み
require_once('db_connect.php');
// function.phpの読み込み
require_once('function.php');

// ログインしていなければ、login.phpにリダイレクト
check_user_logged_in();

// 提出ボタンが押された場合
if (isset($_POST['post'])) {
	$post = $_POST['post'];
    // titleとcontentの入力チェック
    if (empty($_POST['title'])) {
        echo 'タイトルが未入力です。';
    } elseif (empty($_POST['content'])) {
        echo 'コンテンツが未入力です。';
    }
    if ($_POST['title'] && $_POST['content']) {
    	// 入力したtitleとcontentを格納
    	$title = htmlspecialchars($_POST['title'],ENT_QUOTES);
    	$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
        // PDOのインスタンスを取得
        $pdo = db_connect();
        try {
            // SQL文の準備
            $sql = 'INSERT INTO posts (title, content) VALUES (:title, :content)';
            // プリペアドステートメントの準備
            $stmt = $pdo->prepare($sql);
            // タイトルをバインド
            $stmt->bindParam(':title', $title);
            // 本文をバインド
            $stmt->bindParam(':content', $content);
            // 実行
            $stmt->execute();
            // main.phpにリダイレクト
            header('Location: main.php');
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<h1>記事登録</h1>
	<form method="POST" action="">
		title:<br>
		<input type="text" name="title" id="title" style="width:200px;heigh:50px;"><br>
		content:<br>
		<input type="text" name="content" id="content" style="width:200px;height:100px;"><br>
		<input type="submit" value="submit" id="post" name="post">
	</form>
</body>
</html>