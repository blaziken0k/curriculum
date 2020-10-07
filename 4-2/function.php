<?php
//$_SESSION["name"]が空だった場合、ログインページにリダイレクトする
function check_user_logget_in() {
	session_start();
	if (empty($_SESSION["name"])) {
		header("Location: login.php");
		exit;
	}
}
?>