<?php
require_once("db_connect.php");
require_once("function.php");

// ログイン状態でない場合ログインページへ飛ぶ
check_user_logget_in();

// セッション開始
session_start();
// セッション変数のクリア
$_SESSION = array();
// セッションクリア
session_destroy();

// ログインページにリダイレクト
header("Location: login.php");
exit;
?>