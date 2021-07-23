<?php

/** 
 * File Name           : borrower/delete.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../../config.php';

/**
 * :: Delete Borrower
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table       = 'borrower';
    $id          = $_POST['id'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Check the id
    $result = $db->query("SELECT * FROM $table WHERE id='$id'");
    if ($result->num_rows < 1) {
        echo "The Borrower's ID does not exist";
        return;
    }

    // Create default update query
    $sql = "DELETE FROM $table WHERE id='$id'";

    // Execute
    if ($db->query($sql)) {
        echo "The borrower has been deleted!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}