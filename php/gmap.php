<?php

// var_dump($_SESSION["validationMsgs"]);
if(!empty($_SESSION["validationMsgs"])){
  $validation = $_SESSION["validationMsgs"];
}
$validationMsgs = [];
if (!isset($_SESSION["logonFlag"]) || !isset($_SESSION["NAME"]) || !isset($_SESSION["ID"])) {
	$validationMsgs[] = "情報に誤りがあります。ログインし直して下さい。";
    header("Location: goLogOn.php");
    exit;
}

require($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/Photo.php");

$id = $_SESSION["ID"];
$userName = $_SESSION["NAME"];

// var_dump($userName);
$photoList = [];
try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM photoInfo WHERE member_id = :member_id ORDER BY created DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":member_id", $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	  $memberId = $row["member_id"];
    	  $photoId = $row["id"];
        $pht = $row["photo"];
        $shopName = $row["shop_name"];
        $shopUrl = $row["shop_url"];
        $tourist = $row["tourist"];
        $root = $row["root"];
        $comment = $row["comment"];
        // var_dump($memberId);

        $photo = new Photo();
        $photo->setId($photoId);
        $photo->setPhoto($pht);
        $photo->setShopName($shopName);
        $photo->setShopUrl($shopUrl);
        $photo->setTourist($tourist);
        $photo->setRoot($root);
        $photo->setComment($comment);
        $photoList[$photoId] = $photo; 
    }

    $sql2 = "SELECT * FROM members WHERE id = :id";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(":id", $id, PDO::PARAM_INT);
    $result2 = $stmt2->execute();
    if($result2 && $row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $picture = $row2["picture"];
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
else{
  if(!empty($pht)){
	   $_SESSION["member_id"] = $memberId;
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>kyotiko:マイページ</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../css/mainPage.css">
<link rel="stylesheet" type="text/css" href="../css/gmap.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script type="text/javascript" src="../js/jquery-2.0.2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBWL3ftdFyjayPW47hTxBgan9ONt6gop1Y&callback=initMap' async defer></script>
<script src="../js/gmap.js"></script>

</head>

<body>


<div id="header">
	<div id="headerIn">
		<div id="logo">
			<p><img src="../images/kyotiko.png"></p>
			<h1 class="logo kyotiko"><a href="timeLine.php">kyotiko</a></h1>
		</div><!--logo-->
		<div id="search">
			<form id="form1" action="search.php" method="post">
				<div class="input-group mb-3">
 					<div class="input-group-prepend">
    					<span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
	  				</div>
  					<input type="text" name="tourist" class="form-control" placeholder="観光地名を入力" aria-label="Username" aria-describedby="basic-addon1">
				</div>
			</form>
		</div><!--search-->
		<div id="navi">
			<p><img src="../images/heart.png"></p>
			<p><img src="../images/compass.png"></p>
			<p><a href="myPage.php"><img src="../images/myPage.png"></a></p>
		</div><!--navi-->
	</div><!--headerIn-->
</div><!--header-->

<div id="wrapper">
    <div id="contLeft">
        <p>コチラから入力</p>
        <input type="text" id="mapInfo" name="mapInfo" placeholder="観光地やお店を追加" size="20">
        <input type="button" id="button" value="追加">
        <input type="button" id="button1" value="履歴削除">
        <div id="output">
            <p>追加履歴</p>
            <ol>

            </ol>
        </div>
    </div>
    
    <div id="gmap" style="width:75%; height:87vh; position:absolute; top:0; right:0; margin-right:10px; background-color: olive;"></div>
</div>

</script>
</body>
</html>
