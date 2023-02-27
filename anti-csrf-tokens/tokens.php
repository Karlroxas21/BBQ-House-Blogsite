<?php

// Located at index.php
if (!isset($_SESSION['login_token'])) {
    $_SESSION['login_token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['register_token'])) {
    $_SESSION['register_token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['comment_token'])) {
    $_SESSION['comment_token'] = bin2hex(random_bytes(32));
}

//Located at ui_manage_account.php
if (!isset($_SESSION['accountupdate_token'])) {
    $_SESSION['accountupdate_token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['accountdelete_token'])) {
    $_SESSION['accountdelete_token'] = bin2hex(random_bytes(32));
}

// Located at ui_account_update.php
if (!isset($_SESSION['accountupdatesave_token'])) {
    $_SESSION['accountupdatesave_token'] = bin2hex(random_bytes(32));
}

//Located at ui_manage_comment.php
if (!isset($_SESSION['commentdelete_token'])) {
    $_SESSION['commentdelete_token'] = bin2hex(random_bytes(32));
}

?>