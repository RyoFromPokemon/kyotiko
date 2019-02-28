<?php

// var_dump($_POST);

require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/work/class/User.php");

$user = new User();
if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $user = unserialize($user);
    unset($_SESSION["user"]);
}

$validationMsgs = null;
if(isset($_SESSION["validationMsgs"])){
    $validationMsgs = $_SESSION["validationMsgs"];
    unset($_SESSION["validationMsgs"]);
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>kyotiko:TOPページ</title><meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" type="text/css" href="../css/top.css">
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
		<div class="bg-slider">
			<div id="contIn">
				<h1 class="bg-slider__title kyotiko">la kyotiko</h1>
				<p class="bg-slider_cont">
<?php
if(!is_null($validationMsgs)){
?>
        <section>
            <p>以下のメッセージをご確認ください。</p>
            <ul>
<?php
foreach($validationMsgs as $msg){
?>
                <li>※<?= $msg ?></li>
<?php
}
?>
            </ul>
        </section>
<?php
}
?>

				<p>~全人類のkyotoがつながる~</p>
					<form method="post" action="/work/php/signUpConf.php" enctype="multipart/form-data">
						<input type="text" name="addUserName" size="35" placeholder="ユーザーネーム" value="<?= $user->getUserName() ?>" required><br>
						<input type="text" name="addName" size="35" placeholder="氏名" value="<?= $user->getName() ?>" required><br>
						<input type="email" name="addEmail" size="35" placeholder="メールアドレス" value="<?= $user->getEmail() ?>" required><br>
                        <input type="password" name="addPassword" size="35" placeholder="パスワード" value="<?= $user->getPassword() ?>" required><br>
                        <label for="addFavoris">
                            お気に入り観光地<br>
						    <select type="text" name="addFavoris" placeholder="お気に入り観光地" value="" required>
                            <option value="" selected>選択してください</option>
                            <option value="清水寺">清水寺</option>
                            <option value="金閣寺">金閣寺</option>
                            <option value="銀閣寺">銀閣寺</option>
                            <option value="平安神宮">平安神宮</option>
                            <option value="蹴上インクライン">蹴上インクライン</option>
                            <option value="南禅寺">南禅寺</option>
                            <option value="龍安寺">龍安寺</option>
                            <option value="三十三間堂">哲学の道</option>
                            <option value="嵐山">嵐山</option>
                            <option value="鞍馬寺">鞍馬寺</option>
                        </select></label><br>
                        <label for="addPicutre">
                            TOP画像<br>
					        <input id="file" type="file" name="addPicture" value="" required><br>
                        </label>
						<input id="sign" type="submit" name="button" value="新規登録">
					</form>
				<p>アカウントをお持ちですか？ <a href="goLogOn.php">ログインする</a></p>
			</div>
		</div>
			
	</div>
</body>
</html>


<!--
    ■バージョンアップ
    ◆作品
    ・ピンタレストの機能
    ・いいね機能
    ・いいねが多かった人にお店のクーポン
    ・追加してほしい観光地応募フォーム
    ・フォローフォロワー機能
    ・写真にコメントできるように
    ・プロフィール編集
    ・フォローフォロワー機能
    ・object-fit:contain;
    ◆プレゼン
    ・作品を見てもらってる時に、ここにはPHPとかこんだけ頑張りましたって言う
    ・アパレル時代のノウハウをサービスに盛り込む
 -->



 
