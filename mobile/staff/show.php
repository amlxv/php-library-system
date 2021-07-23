<?php

/** 
 * File Name           : staff/show.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../../config.php';

/**
 * :: Show Staff
 * 
 */

// Get post data
$table      = 'staff';

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