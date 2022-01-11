<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../../config.php';

/**
 * :: Delete Staff
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table       = 'staff';
    $id          = $_POST['id'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Check the id
    $result = $db->query("SELECT * FROM $table WHERE id='$id'");
    if ($result->num_rows < 1) {
        echo "The Staff's ID does not exist";
        return;
    }

    // Create default update query
    $sql = "DELETE FROM $table WHERE id='$id'";

    // Execute
    if ($db->query($sql)) {
        echo "The staff has been deleted!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}