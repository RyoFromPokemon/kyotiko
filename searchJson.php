<?php

// var_dump($_SESSION["member_id"]);
require($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");

$tourist = $_SESSION["tourist"];
try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT photoInfo.*, members.user_name, members.picture FROM photoInfo INNER JOIN members ON members.id = photoInfo.member_id WHERE tourist = :tourist ORDER BY created DESC";
    $stmt = $db->prepare($sql);
    $stmt -> bindValue(":tourist", $tourist, PDO::PARAM_STR);
    $result = $stmt->execute();
	$returnArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}
// var_dump($returnArray);
$array = ['photoDetail' => $returnArray];
$json = json_encode($array);
header( 'Content-Type: application/json; charset=utf-8' );
print($json);


