<?php

class Database
{
    // protected $host;
    // protected $username;
    // protected $db_name;
    // protected $password;
    // protected $port;

    protected $mysqli = [];
    protected $db;

    /**
     * :: __constructor
     * 
     * @param string $host
     * @param string $username
     * @param string $db_name
     * @param string $password
     * @param int $port
     * 
     */
    public function __construct($host = null, $username = null, $db_name = null, $password = null, $port = null)
    {
        $this->mysqli = array(
            'host'          => $host,
            'username'      => $username,
            'db_name'       => $db_name,
            'password'      => $password,
            'port'          => $port,
            'isConnected'   => false,
        );

        $this->connect();
    }

    /**
     * :: Connect to Database
     * 
     */
    public function connect()
    {
        $connection = new mysqli($this->mysqli['host'], $this->mysqli['username'], $this->mysqli['password'], $this->mysqli['db_name']);

        // Check SQL Connection
        if ($connection->connect_errno) {
            echo "Database connection error: " . $connection->connect_error;
            die;
        }

        // Create connection variable
        $this->db = $connection;
        return $this->mysqli['isConnected'] = true;
    }

    /**
     * :: Insert Data into Database
     * 
     * @param string $table
     * @param array $columns
     * @param array $values
     * 
     */
    public function insert($table = null, $columns = null, $values = null)
    {

        /**
         * :: H2U 
         * 
         * $table       = 'users';
         * $columns     = ['id', 'name', 'username', 'password'];
         * $values      = ['2019299594', "'Amirul'", "'amlxv'", "'123456'"];
         * 
         * $this->insert($table, $columns, $values);
         */

        /**
         * Check database connection
         * 
         */
        if (!($this->mysqli['isConnected'])) {
            $this->connect();
        }

        /**
         * @return if $table is NULL 
         */

        if (empty($table)) {
            echo "The table cannot be empty";
            return;
        }

        /**
         * @return if (count($columns) != count($values))
         * 
         */
        if (!empty($columns) && !empty($values)) {
            if (count($columns) != count($values)) {
                echo "The columns & values array length must be same";
                return;
            }
        }

        /**
         * Implode each values to string with (, ) separator
         * 
         */
        if (!empty($values)) {
            $values = implode(", ", $values);
        }

        /**
         * Implode each columns to string with (, ) separator
         * @param array $columns
         * 
         */
        if (!empty($columns)) {
            $columns = implode(", ", $columns);

            /**
             * Generate SQL Statements
             * @var string $sql
             * 
             */
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        } else {
            $sql = "INSERT INTO $table VALUES ($values)";
        }

        /**
         * :: Execute insert queries
         * @return msg
         * 
         */
        return ($this->db->query($sql)) ? "successful" : "failed: " . $this->db->error;
    }

    /**
     * :: Update Data from Database
     * 
     * @param string $table
     * @param array $query
     * @param array $condition
     * 
     */
    public function update($table = null, $query = null, $condition = null)
    {
        /**
         * :: H2U
         * 
         * $table       = 'users';
         * $query       = ["id='2019299594', name='Amirul'"];
         * $condition   = ['id=2019', 'name="Jr"'];
         * 
         * $this->update($table $query, $condition);
         */

        /**
         * Check database connection
         * 
         */
        if (!($this->mysqli['isConnected'])) {
            $this->connect();
        }

        /**
         * @return if $table is NULL 
         */

        if (empty($table)) {
            echo "The table cannot be empty";
            return;
        }

        /**
         * Check if empty $query & $condition
         * @return error
         * 
         */
        if (empty($query) || empty($condition)) {
            echo "The query or condition is empty";
            return;
        }

        /**
         * Implode each $query to string with (, ) separator
         * 
         */
        if (!empty($query)) {
            $query = implode(", ", $query);
        }

        /**
         * Implode each $condition to string with ( AND ) separator. 
         * (Only applied if count($condition) > 1)
         * 
         */

        if (!empty($condition)) {
            $condition = implode(" AND ", $condition);
        }

        /**
         * Prepare SQL statement
         * 
         */
        $sql = "UPDATE $table SET $query WHERE $condition";

        /**
         * :: Execute insert queries
         * @return msg
         * 
         */
        return ($this->db->query($sql)) ? "successful" : "failed: " . $this->db->error;
    }

    /**
     * :: Delete Data from Database
     * 
     * @param string $table 
     * @param array $condition
     * 
     */
    public function delete($table = null, $condition = null)
    {
        /**
         * :: H2U
         * 
         * $table       = 'users';
         * $condition   = ['id=2019299594'];
         * 
         * $this->delete($table, $condition);
         */

        /**
         * Check database connection
         * 
         */
        if (!($this->mysqli['isConnected'])) {
            $this->connect();
        }

        /**
         * @return if $table is NULL 
         */

        if (empty($table)) {
            echo "The table cannot be empty";
            return;
        }

        /**
         * Check if empty $condition
         * @return error
         * 
         */
        if (empty($condition)) {
            echo "The condition is empty";
            return;
        }

        /**
         * Implode $condition to string
         * v 1.0 - Only one condition accepted
         *  
         */
        if (!empty($condition)) {
            $condition = $condition[0];
        }

        /**
         * Prepare SQL Statement
         * 
         */
        $sql = "DELETE FROM $table WHERE $condition";

        /**
         * :: Execute delete queries
         * @return msg
         * 
         */
        return ($this->db->query($sql)) ? "successful" : "failed: " . $this->db->error;
    }

    /**
     * :: Select Data from Database
     * 
     * @param string $table
     * @param array $columns
     * @param array $condition
     * @param array $sort
     *  
     * v 1.0 
     * - Basic select only
     * - Can't join the table
     * - Can't determine the sort option (ASC/ DESC)
     */
    public function select($table = null, $columns = null, $condition = null, $sort = null)
    {
        /**
         * :: H2U 
         * 
         * $table       = 'users';
         * $columns     = ['id', 'name', 'username'];
         * $condition   = ['id=2019299594'];
         * $sort        = ['id', 'name'];
         * 
         * $this->select($table, $columns, $condition, $sort);
         */

        /**
         * Check database connection
         * 
         */
        if (!($this->mysqli['isConnected'])) {
            $this->connect();
        }

        /**
         * @return if $table is NULL 
         */

        if (empty($table)) {
            echo "The table cannot be empty";
            return;
        }

        /**
         * Check if $columns is empty
         * If not, implode the $columns into string separated by (, )
         * 
         */
        if (empty($columns)) {
            $columns = '*';
        } else {
            $columns = implode(", ", $columns);
        }

        /**
         * Check if $condition is empty
         * If not, implode the $condition into string separated by (, )
         * 
         */
        if (empty($condition)) {
            $condition = null;
        } else {
            $condition = implode(" AND ", $condition);
        }

        /**
         * Check if $sort is empty
         * If not, implode the $sort into string separated by (, )
         * 
         */
        if (empty($sort)) {
            $sort = null;
        } else {
            $sort = implode(", ", $sort);
        }

        /**
         * :: Define 1's SQL Statement (Default)
         * 
         */
        $sql = "SELECT $columns FROM $table";

        /**
         * Append the $condition to SQL Statement
         * @return $sql
         * 
         */
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        /**
         * Append the $sort to SQL Statement
         * @return $sql
         * 
         */
        if (!empty($sort)) {
            $sql .= " ORDER BY $sort";
        }

        /**
         * :: Execute select queries
         * @return result
         * 
         */
        return ($this->db->query($sql)) ? $this->db->query($sql) : "failed: " . $this->db->error;
    }

    /**
     * :: Count Data from Database
     * 
     * @param string $table
     * @param array $condition
     * 
     * v 1.0 
     * - Count all columns simultaneously
     * - Can't select the columns to be counted
     * - Only AND are available for multiple condition
     * 
     */
    public function count($table = null, $condition = null)
    {
        /**
         * :: H2U 
         * 
         * $table       = 'users';
         * $condition   = ['id=2019299594', 'name="Amirul"'];
         * 
         * $this->count($table, $condition);
         */

        /**
         * Check database connection
         * 
         */
        if (!($this->mysqli['isConnected'])) {
            $this->connect();
        }

        /**
         * @return if $table is NULL 
         */

        if (empty($table)) {
            echo "The table cannot be empty";
            return;
        }

        /**
         * Check if $condition is empty
         * If not, implode the $condition into string separated by (, )
         * 
         */
        if (empty($condition)) {
            $condition = null;
        } else {
            $condition = implode(" AND ", $condition);
        }

        /**
         * :: Generate the SQL Statement (Default)
         * @return $sql
         */
        $sql = "SELECT COUNT(*) FROM $table";

        /**
         * Append $condition if available
         * @return $sql
         */
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        /**
         * :: Execute the count queries
         * 
         */
        return ($this->db->query($sql)) ? $this->db->query($sql)->fetch_array(MYSQLI_NUM)[0] : 'failed: ' . $this->db->error;
    }

    /**
     * :: Custom Query 
     * 
     * @param string $query
     * 
     */
    public function custom_query($query)
    {
        /**
         * :: H2U
         * 
         * $table = 'users';
         * $this->custom_query("SELECT * FROM $table");
         */

        return ($this->db->query($query)) ? $this->db->query($query) : 'failed: ' . $this->db->error;
    }
}