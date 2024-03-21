<?php

include_once("UIFunctions.php");

if (isset($_GET["logout"])) {

    session_unset();
    foreach($_COOKIE as $k => $v) {
        unset($_COOKIE[$k]);
        $params = session_get_cookie_params();
        setcookie($k, '', 1, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header("Location: user-login.php");
    exit;

} elseif (!isset($_SESSION['loggedIn'])) {
    loginFormUI();
} elseif ($_SESSION['loggedIn']) {
    header("Location: Events.php");
}



?>