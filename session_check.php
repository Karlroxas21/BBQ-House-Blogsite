<?php
include('./config.php');

if (!isset($_SESSION['logged_in'])) {
    die();
}

$time_inactive = 60 * 60; // secs*minutes*hour
if (time() - $_SESSION['time'] > $time_inactive) {
    session_destroy();
    echo "<script nonce='sc1'>
    alert('Session expired! You must re-login!');
    window.location.href='index.php';
    </script>";
}
