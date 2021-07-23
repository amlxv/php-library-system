<?php

/** 
 * File Name           : staff/index.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../autoload.php';

if (empty($_SESSION['current_user'])) {
    redirect("../index.php");
}

if ($_SESSION['current_user']['role'] == 'borrower') {
    redirect("../dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
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
                        <a class="btn btn-nav" href="../dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav btn-primary" href="../staff">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../borrower">Borrower</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../book">Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav btn-outline-danger logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End :: Navbar -->

    <div class="container">
        <div class="my-3 d-flex flex-row justify-content-between">
            <h2>Staff</h2>
            <h2><a class="btn btn-success" data-bs-target="#addStaff_modal" data-bs-toggle="modal"><i
                        class="fas fa-plus"></i></a>
            </h2>
        </div>
    </div>

    <!-- Start :: Staff List -->
    <div class="container">
        <?php

        $result = $db->select('staff');
        if ($result->num_rows > 0) {
            echo '
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Details</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody> 
            ';
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td> " . $i . " </td>
                    <td> " . $row['name'] . " </td>
                    <td> " . $row['phone_num'] . " </td>
                    <td><a class='btn btn-outline-primary details' data-bs-toggle='modal' data-bs-target='#detailsStaff_modal' data-user-id='" . $row['id'] . "'>Details</a></td>
                    <td>
                        <div class='text-nowrap'>
                            <a class='btn btn-primary update' data-bs-toggle='modal' data-bs-target='#updateStaff_modal' data-user-id='" . $row['id'] . "' ><i class='fas fa-edit'></i></a>
                            <a class='btn btn-danger delete' data-id='detailsStaff' data-user-id='" . $row['id'] . "' data-user-name='" . $row['name'] . "' ><i class='fas fa-trash-alt'></i></a>
                        </div>
                    </td>
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
            <h3 class='text-center'>No data was found.</h3>
            <p class=text-center>Please contact the administrator</p>
            ";
        }
        ?>
    </div>
    <!-- End :: Staff List -->

    <!-- Start :: Add Staff Modal -->
    <div class="modal fade" id="addStaff_modal" tabindex="-1" aria-labelledby="addStaff_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaff_modalLabel">Add New Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStaff" action="../App/Staff/Staff.php" method="post">
                        <input type="hidden" name="type" value="add">
                        <div class="mb-2">
                            <label class="form-label" for="add_id">Staff ID</label>
                            <input class="form-control" type="text" name="id" id="add_id" placeholder="Staff's ID"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_name">Name</label>
                            <input class="form-control" type="text" name="name" id="add_name" placeholder="Staff's Name"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_phone_num">Phone Number</label>
                            <input class="form-control" type="text" name="phone_num" id="add_phone_num"
                                placeholder="Staff's Phone Number" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_password">Password</label>
                            <input class="form-control" type="password" name="password" id="add_password"
                                placeholder="Staff's Password" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_confirm_password">Confirm Password</label>
                            <input class="form-control" type="password" name="confirm_password"
                                id="add_confirm_password" placeholder="Confirm Password" required>
                            <p id="add_confirm_password_err_msg" class="text-danger d-none">The password must be
                                same.
                            </p>
                        </div>
                        <div class="mt-3">
                            <input class="form-check-input" type="checkbox" name="show_password" id="add_show_password">
                            <label class="form-check-label text-muted" for="add_show_password">Show password</label>
                        </div>

                        <div class="mt-4">
                            <input type="submit" class="btn btn-success float-end ms-2" value="Add New Staff">
                            <button type="button" class="btn btn-danger float-end"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End :: Add Staff Modal -->

    <!-- Start :: Update Staff Modal -->
    <div class="modal fade" id="updateStaff_modal" tabindex="-1" aria-labelledby="updateStaff_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStaff_modalLabel">Update Staff Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStaff" action="../App/Staff/Staff.php" method="post">
                        <input type="hidden" name="type" value="update">
                        <div class="">
                            <label class="form-label" for="update_id">Staff ID</label>
                            <input class="form-control" type="text" name="id" id="update_id" placeholder="Staff's ID"
                                readonly>
                            <p class="text-muted">Staff ID can't be changed.
                            </p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_name">Name</label>
                            <input class="form-control" type="text" name="name" id="update_name"
                                placeholder="Staff's Name">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_phone_num">Phone Number</label>
                            <input class="form-control" type="text" name="phone_num" id="update_phone_num"
                                placeholder="Staff's Phone Number">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_password">Password</label>
                            <input class="form-control" type="password" name="password" id="update_password"
                                placeholder="Staff's Password">

                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_confirm_password">Confirm Password</label>
                            <input class="form-control" type="password" name="confirm_password"
                                id="update_confirm_password" placeholder="Confirm Password">
                            <p id="update_confirm_password_err_msg" class="text-danger d-none">The password must be
                                same.
                            </p>
                            <p class="text-muted">Leave the password blank if you do not want to change
                                them.
                            </p>
                        </div>
                        <div class="mt-3">
                            <input class="form-check-input" type="checkbox" name="show_password"
                                id="update_show_password">
                            <label class="form-check-label text-muted" for="update_show_password">Show password</label>
                        </div>

                        <div class="mt-4">
                            <input type="submit" class="btn btn-success float-end ms-2" value="Update Staff">
                            <button type="button" class="btn btn-danger float-end"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End :: Update Staff Modal -->

    <!-- Start :: Details Staff Modal -->
    <div class="modal fade" id="detailsStaff_modal" tabindex="-1" aria-labelledby="detailsStaff_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsStaff_modalLabel">Staff Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="detailsStaff" action="../App/Staff/Staff.php" method="post">
                        <div class="mb-2">
                            <label class="form-label" for="details_id">Staff ID</label>
                            <input class="form-control" type="text" name="id" id="details_id" placeholder="Staff's ID"
                                readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="details_name">Name</label>
                            <input class="form-control" type="text" name="name" id="details_name"
                                placeholder="Staff's Name" readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="details_phone_num">Phone Number</label>
                            <input class="form-control" type="text" name="phone_num" id="details_phone_num"
                                placeholder="Staff's Phone Number" readonly>
                        </div>

                        <div class="mt-4">
                            <button type="button" class="btn btn-danger float-end"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End :: Details Staff Modal -->

    <div class="container my-5">
        <div class="text-center">
            <div class="text-muted">&copy; 2021 Arclight Company</div>
        </div>
    </div>

</body>

</html>