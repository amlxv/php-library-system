<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../../config.php';

/**
 * :: Update Staff
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table       = 'staff';
    $id          = $_POST['id'];
    $name        = $_POST['name'];
    $phone_num   = $_POST['phone'];
    $password    = $_POST['password'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Check the id
    $result = $db->query("SELECT * FROM $table WHERE id='$id'");
    if ($result->num_rows < 1) {
        echo "The Staff's ID does not exist";
        return;
    }

    // Encrypt password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create default update query
    $sql = "UPDATE $table SET name='$name', password='$hashed_password', phone_num='$phone_num' WHERE id='$id'";

    // Execute
    if ($db->query($sql)) {
        echo "The staff information has been updated!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}