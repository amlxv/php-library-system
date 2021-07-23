<?php

/** 
 * File Name           : book/add.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../../config.php';

/**
 * :: Add Book
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table      = 'book';
    $id         = $_POST['id'];
    $name       = $_POST['name'];
    $author     = $_POST['author'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Find the user with his/her ID
    $sql = "INSERT INTO $table (id, name, author) VALUES ('$id', '$name', '$author')";

    // Execute
    if ($db->query($sql)) {
        echo "A new book has been added!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}