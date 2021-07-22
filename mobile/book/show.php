<?php

require '../../config.php';

/**
 * :: Show Book
 * 
 */

// Get post data
$table      = 'book';

// Database connection
$db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

// Find the user with his/her ID
$sql = "SELECT * FROM $table";

// Create list
$list = "";

// Execute
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $id             = $row['id'];
        $name           = $row['name'];
        $author         = $row['author'];
        $borrower_id    = (!empty($row['borrower_id']) ? $row['borrower_id'] : "-");
        $return_date    = (!empty($row['return_date']) ? $row['return_date'] : "-");
        $temp_list      = "$i) ID: $id \n NAME: $name \n AUTHOR: $author \n BORROWER ID: $borrower_id \n RETURN DATE: $return_date \n";
        $list          .= "\n" . $temp_list;
        $i++;
    }
    echo $list;
} else {
    echo "Failed. Reason: " . $db->error;
}