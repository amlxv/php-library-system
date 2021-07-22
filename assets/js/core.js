$(document).ready(function () {
  // :: Get [$_GET]
  let searchParams = new URLSearchParams(window.location.search);

  // :: Confirm Password Check
  confirmPassword("add");
  confirmPassword("update");

  // :: Show Password
  showPassword("add");
  showPassword("update");
  showPassword("details");

  // :: Add User & Book
  addUser("addStaff");
  addUser("addBorrower");
  addUser("addBook");

  // :: Details User & Book
  detailsUser("detailsStaff");
  detailsUser("detailsBorrower");
  detailsBook("detailsBook");

  // :: Update User (Fill)
  updateUser_fill("updateStaff");
  updateUser_fill("updateBorrower");

  // :: Update Book (Fill)
  updateBook_fill("updateBook");

  // :: Update User & Book (Post)
  updateUser("updateStaff");
  updateUser("updateBorrower");
  updateUser("updateBook");

  // :: Logout User
  $(".logout").on("click", () => {
    logout();
  });

  // :: Delete
  $(".delete").on("click", function () {
    $id = $(this).attr("data-user-id");
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover the data!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonColor: "#555",
      confirmButtonColor: "#d33",
      reverseButtons: true,
    }).then((data) => {
      if (data.isConfirmed) {
        $.ajax({
          url: $("#" + $(this).attr("data-id")).attr("action"),
          type: "post",
          data: {
            type: "delete",
            id: $id,
          },
          success: (data) => {
            if (data === "successful") {
              Swal.fire({
                title: "Successful!",
                text: "The data has been successfully deleted.",
                icon: "success",
              }).then(function () {
                location.reload();
              });
            } else {
              Swal.fire({
                title: "Failed!",
                text: "Something error has occurred. Please re-check the input data.",
                icon: "error",
              });
            }
          },
        });
      } else {
        Swal.fire({
          title: "Cancelled!",
          text: "The data is safe!",
          icon: "info",
        });
      }
    });
  });

  // fx - Dashboard
  $("#find__book_by").on("input", function () {
    enable("find__book");
  });

  $("#find__book").on("input", function () {
    enable("search_book__btn");
  });

  if (searchParams.has("find__book_by") && searchParams.has("find__book")) {
    enable("select__book");
  }

  if (
    searchParams.has("find__borrower_by") &&
    searchParams.has("find__borrower")
  ) {
    enable("select__borrower");
  }

  $("#select__book").on("input", function () {
    enable("select__date");
  });

  $("#select__date").on("input", function () {
    enable("select__book_btn");
  });

  $("#find__borrower_by").on("input", function () {
    enable("find__borrower");
  });

  $("#find__borrower").on("input", function () {
    enable("search_borrower__btn");
  });

  $("#select__borrower").on("input", function () {
    enable("select__borrower_btn");
  });

  // Dashboard :: Submit
  $("#dashboard__form").on("submit", function (e) {
    e.preventDefault();
    if ($("#dashboard__submit").val() == "Reset") {
      return location.replace("../dashboard");
    }
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: $(this).serialize(),
      success: (data) => {
        if (data === "successful") {
          Swal.fire({
            title: "Successful!",
            text: "The book's borrower has been updated!",
            icon: "success",
          }).then(() => {
            location.replace("../dashboard");
          });
        }
      },
    });
  });
});

// fx :: Clear Borrower
function clear_borrower() {
  document.querySelector("#update_borrower_id").value = "";
  document.querySelector("#update_return_date").value = "";
}

// fx : Enables input
function enable(id) {
  $("#" + id).removeAttr("disabled");
}

//  fx : Confirm Password
function confirmPassword(id) {
  $("#" + id + "_confirm_password").on("change", function () {
    if (
      $("#" + id + "_confirm_password").val() != $("#" + id + "_password").val()
    ) {
      $("#" + id + "_confirm_password").addClass("is-invalid");
      $("#" + id + "_confirm_password_err_msg").removeClass("d-none");
    } else {
      $("#" + id + "_confirm_password").removeClass("is-invalid");
      $("#" + id + "_confirm_password_err_msg").addClass("d-none");
    }
  });
}

// fx : Show Password
function showPassword(id) {
  $("#" + id + "_show_password").on("click", function () {
    $("#" + id + "_password").attr("type") === "password"
      ? $("#" + id + "_password").attr("type", "text")
      : $("#" + id + "_password").attr("type", "password");
    $("#" + id + "_confirm_password").attr("type") === "password"
      ? $("#" + id + "_confirm_password").attr("type", "text")
      : $("#" + id + "_confirm_password").attr("type", "password");
  });
}

// fx : Add User
function addUser(id) {
  $("#" + id).submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: $(this).serialize(),
      success: (data) => {
        if (data === "successful") {
          Swal.fire({
            title: "Successful!",
            text: "The new data has been successfully added.",
            icon: "success",
          }).then(function () {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Failed!",
            text: "Something error has occurred. Please re-check the input data.",
            icon: "error",
          });
        }
      },
    }).fail(function () {
      Swal.fire({
        title: "Failed!",
        text: "An unknown error has occurred when adding the data",
        icon: "error",
      });
    });
  });
}

// fx : Details Staff
function detailsUser(id) {
  $(".details").on("click", function () {
    $id = $(this).attr("data-user-id");
    $.ajax({
      url: $("#" + id).attr("action"),
      type: "post",
      data: {
        type: "details",
        id: $id,
      },
      success: (data) => {
        result = data;
        $("#details_id").val(result["id"]);
        $("#details_name").val(result["name"]);
        $("#details_phone_num").val(result["phone_num"]);
      },
      dataType: "json",
    });
  });
}

// fx : Details Book
function detailsBook(id) {
  $(".details").on("click", function () {
    $id = $(this).attr("data-user-id");
    $.ajax({
      url: $("#" + id).attr("action"),
      type: "post",
      data: {
        type: "details",
        id: $id,
      },
      success: (data) => {
        result = data;
        $("#details_id").val(result["id"]);
        $("#details_name").val(result["name"]);
        $("#details_author").val(result["author"]);
        $("#details_borrower_id").val(result["borrower_id"]);
        $("#details_return_date").val(result["return_date"]);
      },
      dataType: "json",
    });
  });
}

// fx : Update Staff (Fill the data)
function updateUser_fill(id) {
  $(".update").on("click", function () {
    $id = $(this).attr("data-user-id");
    $.ajax({
      url: $("#" + id).attr("action"),
      type: "post",
      data: {
        type: "details",
        id: $id,
      },
      success: (data) => {
        result = data;
        $("#update_id").val(result["id"]);
        $("#update_name").val(result["name"]);
        $("#update_phone_num").val(result["phone_num"]);
      },
      dataType: "json",
    });
  });
}

// fx : Update Book (Fill the data)
function updateBook_fill(id) {
  $(".update").on("click", function () {
    $id = $(this).attr("data-user-id");
    $.ajax({
      url: $("#" + id).attr("action"),
      type: "post",
      data: {
        type: "details",
        id: $id,
      },
      success: (data) => {
        result = data;
        $("#update_id").val(result["id"]);
        $("#update_name").val(result["name"]);
        $("#update_author").val(result["author"]);
        $("#update_borrower_id").val(result["borrower_id"]);
        $("#update_return_date").val(result["return_date"]);
      },
      dataType: "json",
    });
  });
}

// fx : Update Staff
function updateUser(id) {
  $("#" + id).submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: $(this).serialize(),
      success: (data) => {
        if (data === "successful") {
          Swal.fire({
            title: "Successful!",
            text: "The data information has been successfully updated.",
            icon: "success",
          }).then(function () {
            location.reload();
          });
        } else {
          Swal.fire({
            title: "Failed!",
            text: "Something error has occurred. Please re-check the input data.",
            icon: "error",
          });
        }
      },
    }).fail(function () {
      Swal.fire({
        title: "Failed!",
        text: "An unknown error has occurred when adding the data",
        icon: "error",
      });
    });
  });
}

// fx : Logout user from session
function logout() {
  Swal.fire({
    title: "Are you sure?",
    text: "You will be logged out from the session!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Log me out!",
    cancelButtonColor: "#555",
    confirmButtonColor: "#d33",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      location.replace("../App/Auth/Auth.php?type=logout");
    } else {
      swal.close();
    }
  });
}
