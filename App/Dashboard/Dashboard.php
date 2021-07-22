<?php

require '../../autoload.php';

class Dashboard
{

    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * :: Update Book Status
     * 
     * @param array $data
     * 
     */
    public function update($data)
    {
        $book_id        = $this->getUniqueID($data['book_id']);
        $borrower_id    = $this->getUniqueID($data['borrower_id']);
        $return_date    = $data['return_date'];

        $query = ["borrower_id='$borrower_id', return_date='$return_date'"];

        echo ($this->db->update('book', $query, ["id = '$book_id'"]));
    }

    /**
     * :: Create a Unique ID from String
     * @param string $data
     * 
     */
    public function getUniqueID($data)
    {
        $data = explode(" -", $data);
        return (str_replace(array('[', ']'), '', $data[0]));
    }
}

$dashboard = new Dashboard($db);

/**
 * If Request to Update
 * 
 */
if (!empty($_POST) && !empty($_POST['book']) && !empty($_POST['borrower'])) {
    $data = [
        'book_id'      => $_POST['book'],
        'borrower_id'  => $_POST['borrower'],
        'return_date'  => $_POST['return_date'],
    ];
    $dashboard->update($data);
}