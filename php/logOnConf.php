<?php

var_dump($_POST);

require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>kyotiko:ログインページ</title>
<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" type="text/css" href="../css/logOn.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="../js/jquery.bgswitcher.js"></script>
<script>
jQuery(function($) {
    $('.bg-slider')
    .bgSwitcher({
        images: ['../images/IMG_1554.jpg','../images/gihei.jpg','../images/azuki.jpg','../images/soba.jpg'], // 切り替える背景画像を指定
        interval: 4000, // 背景画像を切り替える間隔を指定 3000=3秒
        loop: true, // 切り替えを繰り返すか指定 true=繰り返す　false=繰り返さない
        shuffle: true, // 背景画像の順番をシャッフルするか指定 true=する　false=しない
        effect: "fade", // エフェクトの種類をfade,blind,clip,slide,drop,hideから指定
        duration: 500, // エフェクトの時間を指定します。
        easing: "swing", // エフェクトのイージングをlinear,swingから指定
    })
});
</script>
</head>

<body>
    <div id="wrapper">
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION[""], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
        <ul>
            <li><a href="Logout.php">ログアウト</a></li>
        </ul>
            
    </div>
</body>
</html>
