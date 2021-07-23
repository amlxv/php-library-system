<?php

/** 
 * File Name           : Auth.php
 * Project Name        : Simple Library System
 * Author              : amlxv
 * Github Profile      : https://github.com/amlxv
 * Github Repositories : https://github.com/amlxv/simple-library-system
 * Version             : 1.0 - Initial Release
 */

require '../../autoload.php';

class Auth
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * :: Login as: Borrower | Staff
     * @param string $type
     * 
     */
    public function login($data = null)
    {
        if (!empty($data['role'])) {

            /**
             * Collect POST
             * 
             * @var $id
             * @var $password
             * @var $role
             * 
             */
            $id         = $data['id'];
            $password   = $data['password'];
            $role       = $data['role'];

            /**
             * Switch (Roles)
             * 
             */
            switch ($role) {
                case "staff":

                    /**
                     * Get the result from database
                     * @return $result
                     * 
                     */
                    $result = ($this->db->select("$role", '', ["id = '$id'"]));

                    /**
                     * :: Login Procedures
                     * 
                     * 1. Check if the data existence
                     * 2. Verify the password
                     * 3. Create sessions
                     * 4. Redirect
                     * 
                     * @return redirect
                     * 
                     */
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();

                        if (password_verify($password, $row['password'])) {

                            $_SESSION['current_user'] = array(
                                'id'        => $row['id'],
                                'name'      => $row['name'],
                                'phone_num' => $row['phone_num'],
                                'role'      => $data['role'],
                            );
                            redirect("../../dashboard");
                        } else {
                            $_SESSION['login_error'] = [
                                'msg'       => "The ID or Password you entered is incorrect.",
                                'id'        => $id,
                                'password'  => $password,
                            ];
                            redirect("../../auth/$role.php");
                        }
                    } else {
                        $_SESSION['login_error'] = [
                            'msg'       => "We couldn't find your account.",
                            'id'        => $id,
                            'password'  => $password,
                        ];
                        redirect("../../auth/$role.php");
                    }
                case "borrower":

                    /**
                     * Get the result from database
                     * @return $result
                     * 
                     */
                    $result = ($this->db->select("$role", '', ["id = '$id'"]));

                    /**
                     * :: Login Procedures
                     * 
                     * 1. Check if the data existence
                     * 2. Verify the password
                     * 3. Create sessions
                     * 4. Redirect
                     * 
                     * @return redirect
                     * 
                     */
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();

                        if (password_verify($password, $row['password'])) {

                            $_SESSION['current_user'] = array(
                                'id'        => $row['id'],
                                'name'      => $row['name'],
                                'phone_num' => $row['phone_num'],
                                'role'      => $data['role'],
                            );
                            redirect("../../dashboard");
                        } else {
                            $_SESSION['login_error'] = [
                                'msg'       => "The ID or Password you entered is incorrect.",
                                'id'        => $id,
                                'password'  => $password,
                            ];
                            redirect("../../auth/$role.php");
                        }
                    } else {
                        $_SESSION['login_error'] = [
                            'msg'       => "We couldn't find your account.",
                            'id'        => $id,
                            'password'  => $password,
                        ];
                        redirect("../../auth/$role.php");
                    }
            }
        }
    }

    public function logout($data)
    {
        // Destroy session if type is logout.
        ($data['type'] == 'logout') ? session_destroy() : '';

        redirect("../../index.php");
    }
}


$auth = new Auth($db);

/**
 * Auth :: Login
 * 
 */
if (!empty($_POST['type']) && $_POST['type'] == 'login') {

    // Collect all $_POST data used for login purpose.
    $data = array(
        'type'      => $_POST['type'],
        'role'      => $_POST['role'],
        'id'        => $_POST['id'],
        'password'  => $_POST['password'],
    );

    $auth->login($data);
}

/**
 * Auth :: Logout
 * 
 */
if (!empty($_GET['type']) && $_GET['type'] == 'logout') {

    // Collect all $_GET data used for logout purpose.
    $data = array(
        'type' => $_GET['type'],
    );

    $auth->logout($data);
}