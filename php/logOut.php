<?php
// session_start();

// セッションの変数のクリア


// セッションクリア


$validationMsgs = [];
if (isset($_SESSION["logonFlag"]) || isset($_SESSION["NAME"]) || isset($_SESSION["ID"])) {
    $_SESSION = array();
    session_destroy();
    $validationMsgs[] = "ログアウトしました。";
    $_SESSION["validationMsgs"] = $validationMsgs;
    header("Location: /work/php/goLogOn.php");
    exit;
} 
else {
    $_SESSION = array();
    session_destroy();
    $validationMsgs[] = "セッションがタイムアウトしました。";
    $_SESSION["validationMsgs"] = $validationMsgs;
    header("Location: /work/php/goLogOn.php");
    exit;
}

