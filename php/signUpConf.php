<?php
var_dump($_POST);

require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

$fileName = $_FILES["addPicture"]['name'];//
$validationMsgs = [];
if(!empty($fileName)) {//画像がアップロードされていれば
    $ext = substr($fileName , -3);//画像ファイルの拡張子を検査
    if($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
        $validationMsgs[] = "拡張子が違います。ファイルを選びなおしてください";
        $_SESSION["validationMsgs"] = $validationMsgs;
        header("Location: top.php");
        exit;
    }
    else{
        $image = date("YmdHis") . $fileName;
        move_uploaded_file($_FILES["addPicture"]["tmp_name"], "../images/" .$image);
    }
}

$addUserName = $_POST["addUserName"];
$addName = $_POST["addName"];
$addEmail = $_POST["addEmail"];
$addFavoris = $_POST["addFavoris"];
$addPassword = $_POST["addPassword"];
$addPicture = $image;

$user = new User();
$user->setUserName($addUserName);
$user->setName($addName);
$user->setEmail($addEmail);
$user->setFavoris($addFavoris);
$user->setPassword($addPassword);
$user->setPicture($addPicture);

$validationMsgs = [];
$hashedUserPasswd = password_hash($user->getPassword(), PASSWORD_DEFAULT);

try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sqlSelect = "SELECT COUNT(*) AS count FROM members WHERE user_name = :user_name";//重複がないか確認
    $sqlInsert = "INSERT INTO members (user_name, name, email, favoris, password, picture) VALUES (:user_name, :name, :email, :favoris, :password, :picture)";
    
    $stmt = $db->prepare($sqlSelect);
    $stmt->bindValue(":user_name", $user->getUserName(), PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = 1;
    if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $count = $row["count"];
    }

    if($count > 0){
        $validationMsgs[] = "そのユーザーネームはすでに使われています。別のものを使用してください。";
    }

    if(empty($validationMsgs)){
        $stmt = $db->prepare($sqlInsert);
        $stmt->bindValue(":user_name", $user->getUserName(), PDO::PARAM_STR);
        $stmt->bindValue(":name", $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":favoris", $user->getFavoris(), PDO::PARAM_STR);
        $stmt->bindValue(":password", $hashedUserPasswd, PDO::PARAM_STR);
        $stmt->bindValue(":picture", $user->getPicture(), PDO::PARAM_STR);
        $result = $stmt->execute();
        if($result){
            $userId = $db->lastInsertId();
            $_SESSION["logonFlag"] = true;
            $_SESSION["NAME"] = $user->getUserName();
            $_SESSION["ID"] = $userId;
        }
        else{
            $validationMsgs = "新規登録に失敗しました。もう一度初めからやり直してください。";
        }
    }
    else{
        $_SESSION["user"] = serialize($user);/*型を失わずに値を返す*/
        $_SESSION["validationMsgs"] = $validationMsgs;
    }
}
catch(PDOException $ex){
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
}
finally{
    $db = null;
}

if(isset($_SESSION["errorMsg"])){
    header("Location: /work/php/error.php");
    exit;
}
elseif(!empty($validationMsgs)){
    $_SESSION["validationMsgs"] = $validationMsgs;
    header("Location: /work/php/top.php");
    exit;
}
else{
    $validationMsgs = "ようこそ KYOTIKO へ！";
    $_SESSION["validation"] = $validation;
    header("Location: /work/php/myPage.php");
    exit;
}

