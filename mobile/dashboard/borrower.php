<?php

require '../../config.php';

/**
 * :: Show Borrowed Book (Dashboard)
 * 
 */

// Get post data
$id         = $_POST['borrower_id'];
$table      = 'book';

// Database connection
$db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

// Find the user with his/her ID
$sql = "SELECT * FROM $table WHERE borrower_id='$id'";

// Create list
$list = "Below is the list of books that you are borrowing \n";

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
        $temp_list      = "$i. $name by $author. Return before $return_date \n";
        $list          .= "\n" . $temp_list;
        $i++;
    }
    echo $list;
} else {
    echo "You are not borrowing any books yet.";
}