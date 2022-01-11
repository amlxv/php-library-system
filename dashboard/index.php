<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../autoload.php';

if (empty($_SESSION['current_user'])) {
    header("Location: ../index.php");
}

if (!empty($_GET['find__book_by']) && !empty($_GET['find__book'])) {
    $_SESSION['find_book'] = [
        'find__book_by'     => $_GET['find__book_by'],
        'find__book'        => $_GET['find__book'],
    ];
}

if (!empty($_GET['select__book']) && !empty($_GET['select__date'])) {
    $_SESSION['select_book'] = [
        'select__book'     => $_GET['select__book'],
        'select__date'     => $_GET['select__date'],
    ];
}

if (!empty($_GET['find__borrower_by']) && !empty($_GET['find__borrower'])) {
    $_SESSION['find_borrower'] = [
        'find__borrower_by'     => $_GET['find__borrower_by'],
        'find__borrower'     => $_GET['find__borrower'],
    ];
}

if (!empty($_GET['select__borrower'])) {
    $_SESSION['select_borrower'] = [
        'select__borrower'     => $_GET['select__borrower'],
    ];
}

if (empty($_GET)) {
    unset($_SESSION['find_book']);
    unset($_SESSION['select_book']);
    unset($_SESSION['find_borrower']);
    unset($_SESSION['select_borrower']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- jQuery -->
    <script src="../assets/js/jquery-3.6.0.js"></script>
    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../assets/vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Custom Preset -->
    <link rel="stylesheet" href="../assets/css/core.css">
    <script src="../assets/js/core.js"></script>
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
</head>

<body>

    <!-- Start :: Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-lg-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="../assets/img/logo.webp" alt="" srcset="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_navbar"
                aria-controls="main_navbar" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="main_navbar">
                <ul class="navbar-nav mb-1 mt-1 mb-lg-1">
                    <li class="nav-item">
                        <a class="btn btn-nav btn-primary" href="../dashboard">Dashboard</a>
                    </li>
                    <?php
                    if ($_SESSION['current_user']['role'] == 'staff') { ?>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../staff">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../borrower">Borrower</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../book">Book</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="btn btn-nav btn-outline-danger logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End :: Navbar -->

    <!-- Start :: Content (Borrower) -->
    <?php
    if ($_SESSION['current_user']['role'] == 'borrower') {
    ?>
    <div class="container content-borrower">
        <?php
            $id = $_SESSION['current_user']['id'];
            $name = $_SESSION['current_user']['name'];
            $result = $db->select('book', '', ["borrower_id='$id'"]);
            if ($result->num_rows > 0) {
                echo '
            <p> <span class="text-muted"> Welcome, </span> <br>' . $name . '</p>
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Book Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Return Date</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody> 
            ';
                $i = 1;
                while ($row = $result->fetch_assoc()) {

                    $date_diff = ((strtotime($row['return_date']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24));
                    if ($date_diff >= 0) {
                        $details_msg = "<a class='btn btn-primary details'> " . $date_diff . " Days left</a>";
                    } else {
                        $details_msg = "<a class='btn btn-danger details'> Late </a>";
                    }

                    echo "
            <tr>
            <td> " . $i . " </td>
            <td> " . $row['name'] . " </td>
            <td> " . $row['author'] . " </td>
            <td> " . $row['return_date'] . " </td>
            <td> " . $details_msg . " </td>
            </tr>
            ";
                    $i++;
                }
                echo "
            </tbody>
            </table>
            ";
            } else {
                echo "
                    <div class='no-books'>
                        <h3 class='text-center'>You are not borrowing any books yet.</h3>
                        <p class=text-center>Please contact the staff if you have any inquiries.</p>
                    </div>
                    ";
            }
            ?>
    </div>
    <?php
    }
    ?>
    <!-- End :: Content (Borrower) -->

    <!-- Start :: Content (Staff) -->

    <?php
    if ($_SESSION['current_user']['role'] == "staff") {
    ?>
    <div class="container mt-3">
        <div class="card p-4">
            <div class="row">
                <div class="col-md col-sm">
                    <div class="">
                        <h5>Book</h5>
                    </div>
                    <form id="form__search_book" method="get">
                        <div class="mt-3 mb-3">
                            <label class="form-label" for="find__book_by">Search Book</label>
                            <select class="form-select" name="find__book_by" id="find__book_by" required
                                <?= (!empty($_SESSION['select_book'])) ? 'disabled' : '' ?>>
                                <option value="">Find book by using ..</option>
                                <option
                                    <?= (!empty($_SESSION['find_book']) && $_SESSION['find_book']['find__book_by'] == 'id') ? "selected" : "" ?>
                                    value="id">Book's ID</option>
                                <option
                                    <?= (!empty($_SESSION['find_book']) && $_SESSION['find_book']['find__book_by'] == 'name') ? "selected" : "" ?>
                                    value="name">Book's Name</option>
                                <option
                                    <?= (!empty($_SESSION['find_book']) && $_SESSION['find_book']['find__book_by'] == 'author') ? "selected" : "" ?>
                                    value="author">Book's Author</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="text" name="find__book" id="find__book"
                                value="<?= (!empty($_SESSION['find_book']) && !empty($_SESSION['find_book']['find__book'])) ? $_SESSION['find_book']['find__book'] : '' ?>"
                                disabled>
                        </div>
                        <div class="text-right">
                            <input id="search_book__btn" class="btn btn-success" type="submit" value="Find" disabled>
                        </div>
                    </form>
                    <form id="form__select_book" action="" method="get">
                        <div class="mt-3 mb-3">
                            <label class="form-label" for="select__book">Select Book & Return Date</label>
                            <select class="form-select" name="select__book" id="select__book" disabled>
                                <?php
                                    if (!empty($_SESSION['select_book'])) {
                                        echo "<option>" . $_SESSION['select_book']['select__book'] . "</option>";
                                    } else if (!empty($_GET) && !empty($_GET['find__book_by'] && !empty($_GET['find__book']))) {
                                        $find__book_by = $_GET['find__book_by'];
                                        $find__book = $_GET['find__book'];
                                        $result = $db->select('book', '', ["$find__book_by='$find__book'", "borrower_id=''"]);
                                        if ($result->num_rows > 0) {
                                            echo "<option>Select the book to borrow.</option>";
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="[' . $row['id'] . '] - ' . $row['name'] . " by " . $row['author'] . '"> [' . $row['id'] . "] - " . $row['name'] . " by " . $row['author'] . '</option>';
                                            }
                                        } else {
                                            echo "<option>No books found.</option>";
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="date" name="select__date" id="select__date"
                                value="<?= (!empty($_SESSION['select_book']) && !empty($_SESSION['select_book']['select__date'])) ? $_SESSION['select_book']['select__date'] : "" ?>"
                                disabled>
                        </div>
                        <div class="text-right">
                            <input id="select__book_btn" class="btn btn-success" type="submit"
                                value="<?= (!empty($_SESSION['select_book'])) ? "Selected" : 'Select' ?>" disabled>
                        </div>
                    </form>
                </div>
                <div class="col-md col-sm">
                    <div class="">
                        <h5>Borrower</h5>
                    </div>
                    <form id="form__search_borrower" method="get">
                        <div class="mt-3 mb-3">
                            <label class="form-label" for="find__borrower_by">Search Borrower</label>
                            <select class="form-select" name="find__borrower_by" id="find__borrower_by" required
                                <?= (!empty($_GET['select__book']) && !empty($_GET['select__date'])) ? '' : 'disabled' ?>>
                                <option value="">Find borrower by using ..</option>
                                <option
                                    <?= (!empty($_SESSION['find_borrower']) && $_SESSION['find_borrower']['find__borrower_by'] == 'id') ? "selected" : "" ?>
                                    value="id">Borrower's ID</option>
                                <option
                                    <?= (!empty($_SESSION['find_borrower']) && $_SESSION['find_borrower']['find__borrower_by'] == 'name') ? "selected" : "" ?>
                                    value="name">Borrower's Name</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="text" name="find__borrower" id="find__borrower"
                                value="<?= (!empty($_SESSION['find_borrower']) && !empty($_SESSION['find_borrower']['find__borrower'])) ? $_SESSION['find_borrower']['find__borrower'] : '' ?>"
                                disabled>
                        </div>
                        <div class="text-right">
                            <input id="search_borrower__btn" class="btn btn-success" type="submit" value="Find"
                                disabled>
                        </div>
                    </form>
                    <form id="">
                        <div class="mt-3 mb-3">
                            <label class="form-label" for="select__borrower">Select Borrower</label>
                            <select class="form-select" name="select__borrower" id="select__borrower" disabled>
                                <?php
                                    if (!empty($_SESSION['select_borrower'])) {
                                        echo "<option>" . $_SESSION['select_borrower']['select__borrower'] . "</option>";
                                    } else if (!empty($_GET) && !empty($_GET['find__borrower_by'] && !empty($_GET['find__borrower']))) {
                                        $find__borrower_by = $_GET['find__borrower_by'];
                                        $find__borrower = $_GET['find__borrower'];
                                        $result = $db->select('borrower', '', ["$find__borrower_by='$find__borrower'"]);
                                        if ($result->num_rows > 0) {
                                            echo "<option>Select the borrower.</option>";
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="[' . $row['id'] . '] - ' . $row['name'] . '">' . '[' . $row['id'] . '] - ' . $row['name'] . '</option>';
                                            }
                                        } else {
                                            echo "<option>No borrowers found.</option>";
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="text-right mb-3">
                            <input id="select__borrower_btn" class="btn btn-success" type="submit"
                                value="<?= (!empty($_SESSION['select_borrower'])) ? "Selected" : 'Select' ?>" disabled>
                        </div>
                    </form>
                    <form id="dashboard__form" action="../App/Dashboard/Dashboard.php" method="post">
                        <div class="">
                            <input type="hidden" name="book" id="book"
                                value="<?= (!empty($_SESSION['select_book'])) ? $_SESSION['select_book']['select__book'] : '' ?>">
                            <input type="hidden" name="borrower" id="borrower"
                                value="<?= (!empty($_SESSION['select_borrower'])) ? $_SESSION['select_borrower']['select__borrower'] : '' ?>">
                            <input type="hidden" name="return_date" id="return_date"
                                value="<?= (!empty($_SESSION['select_book'])) ? $_SESSION['select_book']['select__date'] : '' ?>">
                            <input id="dashboard__submit"
                                class="btn btn-<?= (!empty($_SESSION['find_book']) && !empty($_SESSION['select_book']) && !empty($_SESSION['find_borrower']) && !empty($_SESSION['select_borrower'])) ? "success" : 'danger' ?> w-100"
                                type="submit"
                                value="<?= (!empty($_SESSION['find_book']) && !empty($_SESSION['select_book']) && !empty($_SESSION['find_borrower']) && !empty($_SESSION['select_borrower'])) ? "Add to Database" : 'Reset' ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    <!-- End :: Content (Staff) -->

    <div class="container my-5">
        <div class="text-center">
            <div class="text-rainbow">&copy; 2021 Arclight Company</div>
        </div>
    </div>

</body>

<!-- Start :: Prevent from Accessing Previous Page -->
<script type="text/javascript">
function preventBack() {
    window.history.forward();
}
setTimeout("preventBack()", 0);
window.onunload = function() {
    null
};
</script>
<!-- End :: Prevent from Accessing Previous Page -->

</html>