<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
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