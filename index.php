<?php

session_start();

if (isset($_GET['page']) && $_GET['page'] !== '') {
    if (file_exists('src\\templates\\' . $_GET['page'] . '.html')) {
        require_once('src\\templates\\' . $_GET['page'] . '.html');
    } else {
        require_once('src\templates\Error404.html');
    }
} else {
    require_once('src\templates\HomePage.html');
}
