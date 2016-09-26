<?php

/**
 * Created by PhpStorm.
 * User: KhoSeokHyun
 * Date: 2016-09-25
 * Time: 오후 7:45
 */

ini_set("display_errors", "1");

session_start();
session_destroy();
header('Location: ./login.html');

?>
