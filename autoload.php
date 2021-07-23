<?php

/** 
 * File Name           : autoload.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require 'App/Database/Database.php';
require 'config.php';

session_start();

$db = new Database(
    $db_conf['host'],
    $db_conf['username'],
    $db_conf['db_name'],
    $db_conf['password'],
);

/**
 * Section :: Helper
 * 
 */
function redirect($url)
{
    return header("Location: $url");
}