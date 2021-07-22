<?php

require '../../config.php';

/**
 * :: Show Borrower
 * 
 */

// Get post data
$table      = 'borrower';

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
        $phone_number   = $row['phone_num'];
        $temp_list      = "$i) ID: $id \n NAME: $name \n PHONE NUMBER: $phone_number \n";
        $list          .= "\n" . $temp_list;
        $i++;
    }
    echo $list;
} else {
    echo "Failed. Reason: " . $db->error;
}