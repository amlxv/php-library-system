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
    <title>Book</title>
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
                        <a class="btn btn-nav" href="../staff">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav" href="../borrower">Borrower</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav btn-primary" href="../book">Book</a>
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
            <h2>Book</h2>
            <h2><a class="btn btn-success" data-bs-target="#addBook_modal" data-bs-toggle="modal"><i
                        class="fas fa-plus"></i></a>
            </h2>
        </div>
    </div>

    <!-- Start :: Book List -->
    <div class="container">
        <?php

        $result = $db->select('book');
        if ($result->num_rows > 0) {
            echo '
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Details</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody> 
            ';
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                $status = (empty($row['borrower_id'])) ? "Available" : "Borrowed";
                $status = ($status == 'Available') ? "<span class='badge bg-success'>Available</span>" : "<span class='badge bg-warning'>Borrowed</span>";
                echo "
                <tr>
                    <td> " . $i . " </td>
                    <td> " . $row['name'] . " </td>
                    <td> " . $status . " </td>
                    <td><a class='btn btn-outline-primary details' data-bs-toggle='modal' data-bs-target='#detailsBook_modal' data-user-id='" . $row['id'] . "'>Details</a></td>
                    <td>
                        <div class='text-nowrap'>
                            <a class='btn btn-primary update' data-bs-toggle='modal' data-bs-target='#updateBook_modal' data-user-id='" . $row['id'] . "' ><i class='fas fa-edit'></i></a>
                            <a class='btn btn-danger delete' data-id='detailsBook' data-user-id='" . $row['id'] . "' data-user-name='" . $row['name'] . "' ><i class='fas fa-trash-alt'></i></a>
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
    <!-- End :: Book List -->

    <!-- Start :: Add Book Modal -->
    <div class="modal fade" id="addBook_modal" tabindex="-1" aria-labelledby="addBook_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBook_modalLabel">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBook" action="../App/Book/Book.php" method="post">
                        <input type="hidden" name="type" value="add">
                        <div class="mb-2">
                            <label class="form-label" for="add_id">Book ID</label>
                            <input class="form-control" type="text" name="id" id="add_id" placeholder="Book's ID"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_name">Name</label>
                            <input class="form-control" type="text" name="name" id="add_name" placeholder="Book's Name"
                                required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="add_author">Author</label>
                            <input class="form-control" type="text" name="author" id="add_author"
                                placeholder="Book's Author" required>
                        </div>

                        <div class="mt-4">
                            <input type="submit" class="btn btn-success float-end ms-2" value="Add New Book">
                            <button type="button" class="btn btn-danger float-end"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End :: Add Book Modal -->

    <!-- Start :: Update Book Modal -->
    <div class="modal fade" id="updateBook_modal" tabindex="-1" aria-labelledby="updateBook_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateBook_modalLabel">Update Book Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateBook" action="../App/Book/Book.php" method="post">
                        <input type="hidden" name="type" value="update">
                        <div class="">
                            <label class="form-label" for="update_id">Book ID</label>
                            <input class="form-control" type="text" name="id" id="update_id" placeholder="Book's ID"
                                readonly>
                            <p class="text-muted">Book ID can't be changed.
                            </p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_name">Name</label>
                            <input class="form-control" type="text" name="name" id="update_name"
                                placeholder="Book's Name">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="update_author">Book's Author</label>
                            <input class="form-control" type="text" name="author" id="update_author"
                                placeholder="Book's Author">
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="update_borrower_id">Borrowed By</label>
                            <input class="form-control" type="text" name="borrower_id" id="update_borrower_id"
                                placeholder="Borrower's ID">
                            <p class='text-muted'>Ignore if the book does not have borrower yet.</p>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="update_return_date">Return Date</label>
                            <input class="form-control" type="date" name="return_date" id=update_return_date>
                            <p class='text-muted'>Ignore if the book does not have borrower yet.</p>
                        </div>

                        <div class="mb-2">
                            <button type="button" onclick="clear_borrower()" class="btn btn-outline-warning">Clear
                                Borrower</button>
                        </div>

                        <div class="mt-4">
                            <input type="submit" class="btn btn-success float-end ms-2" value="Update Book">
                            <button type="button" class="btn btn-danger float-end"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End :: Update Book Modal -->

    <!-- Start :: Details Book Modal -->
    <div class="modal fade" id="detailsBook_modal" tabindex="-1" aria-labelledby="detailsBook_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsBook_modalLabel">Book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="detailsBook" action="../App/Book/Book.php" method="post">
                        <div class="mb-2">
                            <label class="form-label" for="details_id">Book ID</label>
                            <input class="form-control" type="text" name="id" id="details_id" placeholder="Book's ID"
                                readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="details_name">Name</label>
                            <input class="form-control" type="text" name="name" id="details_name"
                                placeholder="Book's Name" readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="details_author">Book's Author</label>
                            <input class="form-control" type="text" name="author" id="details_author"
                                placeholder="Book's Author" readonly>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="details_borrower_id">Borrowed By</label>
                            <input class="form-control" type="text" name="borrower_id" id="details_borrower_id"
                                placeholder="This book does not have a borrower yet." readonly>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="details_return_date">Return Date</label>
                            <input class="form-control" type="text" name="return_date" id=details_return_date
                                placeholder="This book does not have a borrower yet." readonly>
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
    <!-- End :: Details Book Modal -->

    <div class="container my-5">
        <div class="text-center">
            <div class="text-rainbow">&copy; 2021 Arclight Company</div>
        </div>
    </div>

</body>

</html>