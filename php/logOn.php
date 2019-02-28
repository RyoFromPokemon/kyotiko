<?php

var_dump($_POST);

require("password.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

$logOnUser = $_POST["logOnUser"];
$logOnPass = $_POST["logOnPass"];

$user = new User();
$user->setUserName($logOnUser);
$user->setPassword($logOnPass);

$validationMsgs = [];
try {
    var_dump($logOnPass);
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sqlSelect = "SELECT * FROM members WHERE user_name = :user_name";
    $stmt = $db->prepare($sqlSelect);
    $stmt->bindValue(":user_name", $user->getUserName(), PDO::PARAM_STR);
    $result = $stmt->execute();
    if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $pas = $row["password"];
        if (password_verify($logOnPass, $pas)) {
            $_SESSION["logonFlag"] = true;
            $_SESSION["NAME"] = $row["user_name"];
            $_SESSION["ID"] = $row["id"];
        }
        else{
            $validationMsgs[] = "パスワードが違います";
            $_SESSION["validationMsgs"] = $validationMsgs;
        }
    }
    else{
        $validationMsgs[] = "ユーザー名が違うか、アカウントがありません";
        $_SESSION["validationMsgs"] = $validationMsgs;
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["validationMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}

// var_dump($$validationMsgs);

if(empty($validationMsgs)){
    header("Location: /work/php/myPage.php");
    exit;
}
else{
    header("Location: /work/php/goLogOn.php");
    exit;
}


