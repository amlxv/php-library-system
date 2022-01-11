<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../../config.php';

/**
 * :: Update Book
 * 
 */

if (!empty($_POST)) {

    // Get post data
    $table          = 'book';
    $id             = $_POST['id'];
    $name           = $_POST['name'];
    $author         = $_POST['author'];
    $borrower_id    = $_POST['borrower_id'];
    $return_date    = date("Y-m-d", strtotime($_POST['return_date']));

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Check the id
    $result = $db->query("SELECT * FROM $table WHERE id='$id'");
    if ($result->num_rows < 1) {
        echo "The Book's ID does not exist";
        return;
    }

    // Create default update query
    $sql = "UPDATE $table SET name='$name', author='$author', borrower_id='$borrower_id', return_date='$return_date' WHERE id='$id'";

    // Execute
    if ($db->query($sql)) {
        echo "The book information has been updated!";
    } else {
        echo "Failed. Reason: " . $db->error;
    }
}