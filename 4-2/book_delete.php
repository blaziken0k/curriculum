<?php
require_once("db_connect.php");
require_once("function.php");

// ログイン状態でない場合ログインページへ飛ぶ
check_user_logget_in();

$id = $_GET["id"];
// $idが空であればインデックスにリダイレクト
if (empty($id)) {
	header("Location: index.php");
	exit;
}

$pdo = db_connect();

try {
	$sql = "DELETE FROM books WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(":id", $id);
	$stmt->execute();
	// 削除完了したらインデックスにリダイレクト
	header("Location: index.php");
	exit;
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
	die();
}
?>