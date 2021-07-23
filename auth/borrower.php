<?php

/** 
 * File Name           : borrower.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../autoload.php';

if (!empty($_SESSION['current_user'])) {
    redirect("../dashboard");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Borrower</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../assets/js/jquery-3.6.0.js"></script>
    <script src="../assets/vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/core.css">
    <script src="../assets/js/core.js"></script>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
</head>

<body>

</body>

</html>

<div class="container">
    <div class="row justify-content-center align-content-center height-100vh">
        <div class="col col-lg-5">
            <div class="text-center">
                <a href="../index.php"><img src="../assets/img/logo.webp" alt="" srcset="" width="160px"></a>
            </div>
            <form action="../App/Auth/Auth.php" method="post">
                <input type="hidden" name="type" value="login">
                <input type="hidden" name="role" value="borrower">
                <div class="my-3">
                    <input class="form-control <?= (isset($_SESSION['login_error'])) ? "is-invalid" : "" ?>" type="text"
                        name="id" value="<?= (isset($_SESSION['login_error'])) ? $_SESSION['login_error']['id'] : "" ?>"
                        required>
                </div>
                <div class="mb-3">
                    <input class="form-control <?= (isset($_SESSION['login_error'])) ? "is-invalid" : "" ?>"
                        type="password" name="password"
                        value="<?= (isset($_SESSION['login_error'])) ? $_SESSION['login_error']['password'] : "" ?>"
                        required>
                </div>
                <?php
                if (isset($_SESSION['login_error'])) {
                ?>
                <div class="mb-3">
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['login_error']['msg'] ?>
                    </div>
                </div>
                <?php } ?>
                <div class="mb-3"><input class="btn btn-primary w-100" type="submit" value="Sign In"></div>
            </form>
            <p class="text-muted">Not a borrower? Login as <a href="staff.php">staff</a>
            </p>
        </div>
    </div>
</div>

<?php
unset($_SESSION['login_error']);
?>