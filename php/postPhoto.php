<?php
// var_dump($_SESSION);


require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Photo.php");

$validationMsgs = [];
if (!isset($_SESSION["logonFlag"]) || !isset($_SESSION["NAME"]) || !isset($_SESSION["ID"])) {
    $validationMsgs[] = "情報に誤りがあります。ログインし直して下さい。";
    header("Location: goLogOn.php");
    exit;
}

$exp = ".jpg";
if($_FILES["addPhoto"]["type"] == "image/png") {
    $exp = ".png";
}
elseif($_FILES["addPhoto"]["type"] == "image/gif") {
    $exp = ".gif";
}
elseif($_FILES["addPhoto"]["type"] == "image/jpeg") {
    $exp = ".jpg";
}
else{
    $validationMsgs[] = "ファイルタイプが指定と違います。";

}

$photoName = "photoImg_".date("YmdHis").rand(1, 100).$exp;
move_uploaded_file($_FILES["addPhoto"]["tmp_name"], "../images/" .$photoName);

$addShopName = $_POST["addShopName"];
$addShopUrl = $_POST["addShopUrl"];
$addTourist  = $_POST["addTourist"];
$addRoot = $_POST["addRoot"];
$addComment = $_POST["addComment"];

$userId = $_SESSION["ID"];
$photoList = [];

try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sqlInsert = "INSERT INTO photoInfo (photo, shop_name, shop_url, tourist, root, comment, member_id, created) VALUES (:photo, :shop_name, :shop_url, :tourist, :root, :comment, :member_id, now())";
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(":member_id", $userId, PDO::PARAM_INT);
    $stmt->bindValue(":photo", $photoName, PDO::PARAM_STR);
    $stmt->bindValue(":shop_name", $addShopName, PDO::PARAM_STR);
    $stmt->bindValue(":shop_url", $addShopUrl, PDO::PARAM_STR);
    $stmt->bindValue(":tourist", $addTourist, PDO::PARAM_STR);
    $stmt->bindValue(":root", $addRoot, PDO::PARAM_STR);
    $stmt->bindValue(":comment", $addComment, PDO::PARAM_STR);
    $result = $stmt->execute();

    $sqlSelect = "SELECT * FROM photoInfo INNER JOIN members ON photoInfo.member_id = members.id ORDER BY created DESC";
    $stmt = $db->prepare($sqlSelect);
    $result = $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $addPhoto = $photoName;
        // $addShopName = $_POST["addShopName"];
        // $addTourist = $_POST["addTourist"];
        // $addRoot = $_POST["addRoot"];
        // $addComment = $_POST["addComment"];

        $photo = new Photo();
        $photo->setPhoto($addPhoto);
        $photo->setShopName($addShopName);
        $photo->setShopUrl($addShopUrl);
        $photo->setTourist($addTourist);
        $photo->setRoot($addRoot);
        $photo->setComment($addComment);
        $photoList[$userId] = $photo;
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
    $_SESSION["errorMsg"] = $errorMsg;
    header("Location: /work/php/error.php");
    exit;
}
elseif(!empty($validationMsgs)){
    $_SESSION["validationMsgs"] = $validationMsgs;
    header("Location: /work/php/myPage.php");
    exit;
}
else{
    header("Location: /work/php/myPage.php");
    exit;
}

