<?php

 $errorMsg = "もう一度始めから操作をお願いします";
 if(isset($_SESSION["errorMsg"])){
     $errorMsg = $_SESSION["errorMsg"];
 }

 unset($_SESSION["errorMsg"]);
 ?>

 <!DOCTYPE html>
 <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Shinzo SAITO">
        <title>Error | ScottAdmin Sample</title>
    </head>
    <body>
        <h1>Error</top>
        <section>
            <h2>申し訳ございません。障害が発生しました。</h2>
            <p>
                以下のメッセージをご確認ください。<br>
                <?= $errorMsg ?>
            </p>
        </section>
        <p><a href="/work/php/myPage.php/">マイページへ戻る</a></p>
    </body>
 </html>
 