<?php
// var_dump($_POST);

require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");


try{
	$db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	$sql = "SELECT * FROM members ORDER BY user_name";
	$stmt = $db -> prepare($sql);
	// $stmt -> bindValue(":user_name", $user->gerUserName(), PDO::PARAM_STR);
	$result = $stmt->execute();
	$userList = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $ex){
	print("DB接続に失敗しました");
}
finally{
	$db = null;
}

$json = json_encode($userList);
header( 'Content-Type: application/json; charset=utf-8' );
print($json);

