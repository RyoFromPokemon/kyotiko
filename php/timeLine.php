<?php

// var_dump($_SESSION);

require($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/Photo.php");
require($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

$id = $_SESSION["ID"];
$userName = $_SESSION["NAME"];

$photoList = [];
$userList = [];
try{
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT photoInfo.*, members.user_name, members.picture FROM photoInfo INNER JOIN members ON members.id = photoInfo.member_id ORDER BY created DESC";
    $stmt = $db->prepare($sql);
    // $stmt->bindValue(":member_id", $id, PDO::PARAM_INT);
    $result = $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)/*,$row4 = $stmt4->fetch(PDO::FETCH_ASSOC)*/){
    	$memberId = $row["member_id"];
    	$photoId = $row["id"];
        $pht = $row["photo"];
        $tourist = $row["tourist"];
        $root = $row["root"];
        $comment = $row["comment"];

        $photo = new Photo();
        $photo->setId($photoId);
        $photo->setPhoto($pht);
        $photo->setTourist($tourist);
        $photo->setRoot($root);
        $photo->setComment($comment);
        $photoList[$photoId] = $photo;


        $userName4 = $row["user_name"];
        $picture4 = $row["picture"];

        $user4 = new User();
        $user4->setUserName($userName4);
        $user4->setPicture($picture4);
        $userList[$photoId] = $user4;
    }
    // var_dump($memberId);

    $sql2 = "SELECT * FROM members WHERE id = :id";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(":id", $id, PDO::PARAM_INT);
    $result2 = $stmt2->execute();
    if($result2 && $row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $picture = $row2["picture"];
  	}

    $fllwList = [];
    for($i =9; $i <= 16; $i++){
        $fllwId = $i;
        $sql3 = "SELECT * FROM members WHERE id = :id";
        $stmt3 = $db->prepare($sql3);
        $stmt3->bindValue(":id", $fllwId, PDO::PARAM_INT);
        $result3 = $stmt3->execute();
        if($result3 && $row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
            $picture3 = $row3["picture"];
            $userName3 = $row3["user_name"];

            $user = new User();
            $user->setPicture($picture3);
            $user->setUserName($userName3);
            $fllwList[] = $user;
        }
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
<title>kyotiko:検索タイムライン</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" type="text/css" href="../css/mainPage.css">
<link rel="stylesheet" type="text/css" href="../css/timeLine.css">
</style>
<script type="text/javascript" src="../js/jquery-2.0.2.min.js"></script>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

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
		<div id="wrapperIn">
			<div id="contLeft">
    			<ul>
<?php
foreach(array_map(null, $photoList, $userList) as [$photo, $user]){
?>

					<div class="cont">
                        <div class="userInfo">
                            <li><a href="#"><img src="../images/<?= $user->getPicture() ?>"></a></li>
                            <li><a href="#"><?= $user->getUserName() ?></a></li>
                        </div>
	    				<li class="postPhoto"><img src="../images/<?= $photo->getPhoto() ?>" width="500px"></li>
    					<div class="contInfo">
	    					<li>#<?= $photo->getTourist() ?></li>
    						<li><?= $photo->getRoot() ?>の近く！</li>
    						<li>コメント：<?= $photo->getComment() ?></li>
    					</div><!--contInfo-->
    				</div><!--cont-->
<?php
}
?>
    			</ul>
    		</div><!--contLeft-->
    		<div id="contRight">
                <div id="contRightIn">
        			<p><img src="../images/<?= $picture ?>"></p>
                    <p><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></p>
                </div><!--contRightIn-->
                <div id="contFollow">
                    <p>オススメフォロワー</p>
                    <dl id="followList">
<?php
foreach($fllwList as $user){
?>
                        <div class="followInfo">

                            <dt><img src="../images/<?= $user->getPicture() ?>"></a></dt>
                            <dd><?= $user->getUserName() ?></dd>
                        </div>
<?php
}
?>
                    </dl>
                </div>
    		</div><!--contRight-->

    	</div><!--wrapperIn-->
	</div><!--wrapper-->
</body>
</html>
