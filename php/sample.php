<?php

// var_dump($_POST);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>kyotiko:検索タイムライン</title>
<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="../css/all.css"> -->
<link rel="stylesheet" type="text/css" href="../css/sample.css">
</style>
<script src="http://www.google.com/jsapi"></script>
<script src="../js/jquery.xdomainajax.js"></script>
<script type="text/javascript" src="../js/jquery-2.0.2.min.js"></script>
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="../js/timeLine.js"></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDY9je1vemt1VF4wA0s4Uqf6XT5pqItaHk&callback=initMap" async defer></script> --><!--googlemapのリンク-->
</head>

<body>
	<div id="header">
		<div id=headerIn>
			<div id="logo">
				<p><img src="../images/kyotiko.png"></p>
				<h1 class="logo">kyotiko</h1>
			</div><!--logo-->
			<div id="search">
				<form id="form1" action="自分のサイトURL" method="post">
					<input id="sbox1" id="s" name="s" type="search" placeholder="キーワードを入力" />
					<input id="sbtn1" type="submit" value="検索" />
				</form>
			</div><!--search-->
			<div id="navi">
				<p><img src="../images/heart.png"></p>
				<p><img src="../images/compass.png"></p>
				<p><img src="../images/myPage.png"></p>
			</div><!--navi-->
		</div><!--headerIn-->
	</div><!--header-->


	<div id="wrapper">
		<!--json出力div-->
  		<div id="data_list">
    		<ul>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
          <div class="polaroid ui-draggable">
            <li><img src="../images/kiyo.jpg"></li>
          </div>
    		</ul>
  		</div><!--data_list-->
  		<div id="data_detail">
  	
  		</div><!--data_detail-->
	</div>
</body>
</html>
