<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../../autoload.php';

class Book
{

    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * :: Add Book to Database
     * @param array $data
     * 
     */
    public function add($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $author = $data['author'];

        echo ($this->db->insert('book', ['id', 'name', 'author'], ["'$id'", "'$name'", "'$author'"]));
    }

    /**
     * :: Update Book's Information to Database
     * @param array $data
     * 
     */
    public function update($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $author = $data['author'];
        $borrower_id = $data['borrower_id'];
        $return_date = $data['return_date'];

        $query = ["name='$name', author='$author'"];

        if (!empty($data['borrower_id'] && !empty($data['return_date']))) {
            $query[0] .= ", borrower_id='$borrower_id', return_date='$return_date'";
        } else {
            $query[0] .= ", borrower_id='', return_date=''";
        }

        echo ($this->db->update('book', $query, ["id = '$id'"]));
    }

    /**
     * :: Delete Book from Database
     * @param array $data
     * 
     */
    public function delete($data)
    {
        $id = $data['id'];
        echo ($this->db->delete('book', ["id = '$id'"]));
    }
}

$book = new Book($db);

/**
 * :: Check data from $_POST
 * 
 */
if (!empty($_POST) && $_POST['type'] == "add") {

    /**
     * Collect the $_POST data into $data
     * 
     */
    $data = array(
        'id'        => htmlspecialchars($_POST['id']),
        'name'      => htmlspecialchars($_POST['name']),
        'author'    => htmlspecialchars($_POST['author']),
    );
    $book->add($data);
}

// If Request for Delete
if (!empty($_POST) && $_POST['type'] == "delete") {
    $data  = [
        'id'    => $_POST['id'],
    ];
    $book->delete($data);
}

//  Get the data for filling up the update form
if (!empty($_POST) && $_POST['type'] == 'details') {

    $id = $_POST['id'];
    $result = $db->select('book', '', ["id = '$id'"]);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $data = [
            'id'            => $row['id'],
            'name'          => $row['name'],
            'author'        => $row['author'],
            'borrower_id'   => $row['borrower_id'],
            'return_date'   => $row['return_date'],
        ];
    }
    echo json_encode($data);
}

// If Request for Update
if (!empty($_POST) && $_POST['type'] == 'update') {

    /**
     * Collect the $_POST data into $data
     * 
     */
    $data = array(
        'id'            => htmlspecialchars($_POST['id']),
        'name'          => htmlspecialchars($_POST['name']),
        'author'        => htmlspecialchars($_POST['author']),
        'borrower_id'   => htmlspecialchars($_POST['borrower_id']),
        'return_date'   => htmlspecialchars($_POST['return_date']),
    );

    $book->update($data);
}