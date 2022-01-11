<?php

/** 
 * @author amlxv
 * @link https://github.com/amlxv
 * @see https://github.com/amlxv/simple-library-system
 */

require '../../autoload.php';

class Staff
{

    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * :: Add Staff to Database
     * @param array $data
     * 
     */
    public function add($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $phone_num = $data['phone_num'];
        $password = $data['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        echo ($this->db->insert('staff', ['id', 'name', 'phone_num', 'password'], ["'$id'", "'$name'", "'$phone_num'", "'$hashed_password'"]));
    }

    /**
     * :: Update Staff's Information to Database
     * @param array $data
     * 
     */
    public function update($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $phone_num = $data['phone_num'];
        $query = ["name='$name', phone_num='$phone_num'"];

        if (!empty($data['password'])) {
            $password = $data['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query[0] .= ", password='$hashed_password'";
        }
        echo ($this->db->update('staff', $query, ["id = '$id'"]));
    }

    /**
     * :: Delete Staff from Database
     * @param array $data
     * 
     */
    public function delete($data)
    {
        $id = $data['id'];
        echo ($this->db->delete('staff', ["id = '$id'"]));
    }
}

$staff = new Staff($db);

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
        'phone_num' => htmlspecialchars($_POST['phone_num']),
        'password'  => $_POST['password'],
    );
    $staff->add($data);
}

// If Request for Delete
if (!empty($_POST) && $_POST['type'] == "delete") {
    $data  = [
        'id'    => $_POST['id'],
    ];
    $staff->delete($data);
}

//  Get the data for filling up the update form
if (!empty($_POST) && $_POST['type'] == 'details') {

    $id = $_POST['id'];

    $result = $db->select('staff', '', ["id = '$id'"]);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $data = [
            'id'        => $row['id'],
            'name'      => $row['name'],
            'phone_num' => $row['phone_num'],
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
        'id'        => htmlspecialchars($_POST['id']),
        'name'      => htmlspecialchars($_POST['name']),
        'phone_num' => htmlspecialchars($_POST['phone_num']),
        'password'  => $_POST['password'],
    );
    $staff->update($data);
}