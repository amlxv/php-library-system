<?php

require '../../config.php';

/**
 * :: Delete Book
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table       = 'book';
    $id          = $_POST['id'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Check the id
    $result = $db->query("SELECT * FROM $table WHERE id='$id'");
    if ($result->num_rows < 1) {
        echo "The Book's ID does not exist";
        return;
    }

    // Create default update query
    $sql = "DELETE FROM $table WHERE id='$id'";

    // Execute
    if ($db->query($sql)) {
        echo "The book has been deleted!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}