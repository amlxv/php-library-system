<?php

/** 
 * File Name           : index.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require 'autoload.php';

if (!empty($_SESSION['current_user'])) {
    redirect("dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/landing-page.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="container hero d-flex align-items-center">
        <div class="hero__login">
            <h2>Library System</h2>
            <p class="text-muted">Login as:</p>
            <a class="btn btn-primary w-100 mb-3" href="auth/borrower.php">Borrower</a>
            <a class="btn btn-success w-100" href="auth/staff.php">Staff</a>
            <div class="w-100 text-center mt-2">
                <a style="text-decoration: none;" href="erd.php">Entitiy Relationship Diagram (ERD)</a>
            </div>
            <div class="mt-3">
                <p class="text-muted">Developed by: <a href="team.php" style="text-decoration: none;"><span
                            class="text-rainbow">Arclight
                            Company</span></a></p>
            </div>
        </div>
        <div class="hero__ill1">
            <img src="assets/img/ill-1.webp" alt="">
        </div>
    </div>

</body>

</html>