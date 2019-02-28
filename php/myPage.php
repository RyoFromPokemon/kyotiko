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
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" type="text/css" href="../css/mainPage.css">
<link rel="stylesheet" type="text/css" href="../css/myPage.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script type="text/javascript" src="../js/jquery-2.0.2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script src="../js/jquery.bpopup.js"></script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBWL3ftdFyjayPW47hTxBgan9ONt6gop1Y&callback=initMap' async defer></script>

<script src="../js/myPage.js"></script>
<style rel="stylesheet" type="text/css">
#demo-popup{
  display: none;
  border: solid 1px #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 400px;
  height: 300px;
  text-align: center;
  margin-top: -250px;
  margin-left: 10px;
  border: solid 1px #FFF;
  background: rgba(255,255,255,0.5);
}
#demo-popup input{
  margin-bottom: 10px;
}
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
if(!empty($validation)){
?>
          <p id="thanks"><?= $validation ?></p>
<?php
}
?>

	<div id="profile">
		<div id="profLeft">
			<p><img src="../images/<?= $picture ?>"></p>
		</div><!--profLeft-->
		<div id="profRight">
			<div id="infoTop">
    			<p><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></p>
	    		<!-- <p>プロフィールを編集</p> -->
    			<p id="demo-button"><a href="#">画像を投稿</a></p>
    			<p><a color="#000" href="logOut.php">ログアウト</a></p>
    		</div><!--infoTop-->
    		<div id="infoCenter">
    		  	<ul>
    			   <li>投稿<?= $count ?>件</li>
					   <li>フォロワー20人</li>
					   <li>フォロー32人</li>
				    </ul>
			  </div><!--infoCenter-->
			  <!-- <p>自己紹介文</p> -->
		</div><!--profRight-->
	</div><!--profile-->


	<div id="contIn">
		<ul>
<?php
foreach($photoList as $photo){
?>
    <div class="photoIn">
	 		<li><img src="../images/<?= $photo->getPhoto() ?>" ></li>
      <div class="mask">
        <div class="caption">It's fresh !</div>
      </div>
    </div>
<?php
}
?>
		</ul>
	</div>
</div>


<script>
$(document).ready(function() {
  $('#demo-button').bind('click', function(e) {
    e.preventDefault();
    $('#demo-popup').bPopup({
      follow: [false, false],
      position: [500, 500],
    });
  });
});
</script>
<div id="demo-popup">
  <p>写真を投稿</p>
	<form method="post" action="/work/php/postPhoto.php" enctype="multipart/form-data">
		<input type="file" name="addPhoto" placeholder="画像" value="" required><br>
    <input type="text" name="addShopName" size="35" placeholder="お店の名前" value="" required><br>
    <input type="text" name="addShopUrl" size="35" placeholder="お店のURL" value="" required><br>
		<input type="text" name="addTourist" size="35" placeholder="近くの観光地" value="" required><br>
		<input type="text" name="addRoot" size="35" placeholder="観光ルート" value="" required><br>
		<input type="text" name="addComment" size="35" placeholder="コメント" value="" required><br>
		<input type="submit" name="" value="投稿">
	</form>
</div>

<div id="bgBox"></div>

  <div id="cont_detail">
  </div>
  <div id="gmap" style="width:450px;height:250px;display:none;" ></div>



</body>
</html>
