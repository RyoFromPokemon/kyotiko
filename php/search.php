<?php

$tourist = $_POST["tourist"];

$touList = ["清水寺","金閣寺","銀閣寺","平安神宮","蹴上インクライン","南禅寺","龍安寺","哲学の道","嵐山","鞍馬寺"];
$picList = ["kiyo.jpg","gold.jpg","silver.jpg","heian.jpg","keage.jpg","nanzenji.jpg","ryouan.jpg","tetsugaku.jpg","arashiyama.jpg","kurama.jpg"];
foreach($touList as $key => $tou){
    if($tourist === $tou){
        $pic = $picList[$key];
        break;
    }
}


$validationMsgs = [];
if (!isset($_SESSION["logonFlag"]) || !isset($_SESSION["NAME"]) || !isset($_SESSION["ID"])) {
	$validationMsgs[] = "情報に誤りがあります。ログインし直して下さい。";
    header("Location: goLogOn.php");
    exit;
}

require($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/Photo.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

$tourist = $_POST["tourist"];

$id = $_SESSION["ID"];
$userName = $_SESSION["NAME"];

// var_dump($userName);
$photoList = [];
try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT photoInfo.*, members.user_name, members.picture FROM photoInfo INNER JOIN members ON members.id = photoInfo.member_id WHERE tourist = :tourist ORDER BY created DESC";
	$stmt = $db->prepare($sql);
    $stmt->bindValue(":tourist", $tourist, PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = $stmt->rowCount();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	$memberId = $row["member_id"];
    	$photoId = $row["id"];
        $pht = $row["photo"];
        $shopName = $row["shop_name"];
        $tourist = $row["tourist"];
        $root = $row["root"];
        $comment = $row["comment"];
        // var_dump($memberId);

        $photo = new Photo();
        $photo->setId($photoId);
        $photo->setPhoto($pht);
        $photo->setShopName($shopName);
        $photo->setTourist($tourist);
        $photo->setRoot($root);
        $photo->setComment($comment);
        $photoList[$photoId] = $photo; 

        $userName = $row["user_name"];
        $picture = $row["picture"];

        $user = new User();
        $user->setUserName($userName);
        $user->setPicture($picture);
        $userList[$photoId] = $user;
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
	   $_SESSION["tourist"] = $tourist;
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>kyotiko:検索結果ページ</title>
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" type="text/css" href="../css/mainPage.css">
<link rel="stylesheet" type="text/css" href="../css/search.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script type="text/javascript" src="../js/jquery-2.0.2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<!-- <script src="../js/myPage.js"></script> -->
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBWL3ftdFyjayPW47hTxBgan9ONt6gop1Y&callback=initMap' async defer></script>
<script src="../js/search.js"></script>
</style>
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
  					<input type="text" name="search" class="form-control" placeholder="観光地名を入力" aria-label="Username" aria-describedby="basic-addon1">
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

<?php
if(!empty($validationMsgs)){
?>
        <section id="errorMsg">
            <p>以下のメッセージをご確認ください。</p>
            <ul>
<?php
foreach($validationMsgs as $msg){
?>
                <li><?= $msg ?></li>
<?php
}
?>
            </ul>
        </section>
<?php
}
?>

<div id="srch">
	<div id="srchLeft">
		<p><img src="../images/<?= $pic ?>"></p>
	</div><!--srchLeft-->
	<div id="srchRight">
			<p>#<?= $tourist ?></p>
			<p>検索結果<?= $count ?>件</a></p>
	</div><!--srchRight-->
</div><!--srch-->

	<div id="contIn">
		<ul>
<?php
foreach($photoList as $photo){
?>
        <div class="photoIn">
			<li><img src="../images/<?= $photo->getPhoto() ?>" ></li>
            <div class="mask">
                <div class="caption"> click ! <br>more info</div>
            </div>
        </div>
<?php
}
?>
		</ul>
	</div>
</div>



<div id="bgBox"></div>

<div id="cont_detail">
</div>
<div id="gmap" style="width:350px;height:350px;display:none;" ></div>

</body>
</html>
