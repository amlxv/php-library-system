<?php

require '../../config.php';

if (!empty($_POST)) {

    // Get post data
    $table      = 'borrower';
    $id         = $_POST['id'];
    $password   = $_POST['password'];

    // Database connection
    $db = new mysqli($db_conf['host'], $db_conf['username'], $db_conf['password'], $db_conf['db_name']) or die;

    // Find the user with his/her ID
    $sql = "SELECT * FROM $table WHERE id='$id'";

    // Store result
    $result = $db->query($sql);

    if ($result->num_rows > 0) {

        // Get the user's hashed password from Database
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            echo "Successfully Login";
        } else {
            echo "You have entered a wrong password";
        }
    } else {
        echo "Your account does not exist";
    }
}