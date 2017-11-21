<?php

class DBConnection {

    // constructor
    private $con;

    function __construct() {
        $this->connect();
    }

    // destructor
    function __destruct() {
        // $this->close();
    }

    public function connect() {
        require_once (dirname(__FILE__) . "/config.php");
        // connecting to mysql
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        // Check connection
        if ($this->con->connect_error) {
            die("Connection failed: ");
        }
    }

    public function db_insert($table, $values, $columns = array()) {
        if ($table == "" || $values == "") {
            return false;
        }
        $columnstr = $valuestr = "";
        if (count($columns) > 0) {
            $columnstr = implode(",", $columns);
            $columnstr = "(" . $columnstr . ")";
        }
        foreach ($values as $key => $val) {
            if ($valuestr != "") {
                $valuestr .= ", '" . $this->con->real_escape_string($val) . "'";
            } else {
                $valuestr = "'" . $this->con->real_escape_string($val) . "'";
            }
        }
        $sql = "INSERT INTO " . $table . " " . $columnstr . " VALUES (" . $valuestr . ")";
        //echo $sql; exit();
        if ($this->con->query($sql)) {
            return $this->con->insert_id;
        } else {
            return false;
        }
    }

    /*
      db_delete deletes record to database.
      params: table name without , condtion without where
      return: success or failure
     */

    public function db_delete($table, $condition = "") {
        if ($table == "") {
            return false;
        }
        if ($condition != "") {
            $condition = " WHERE " . $condition;
        }
        $sql = "DELETE  FROM " . $table . " " . $condition;
        if ($this->con->query($sql)) {
            return $this->con->affected_rows;
        } else {
            return false;
        }
    }

    /*
      db_update.
      params: table name without prefix, columns as array, values as array, condition without where as string

     */

    public function db_update($table, $columns, $values, $condition = "") {
        if ($table == "" || $columns == "" || $values == "") {
            return false;
        }
        if (count($columns) != count($values)) {
            return false;
        }
        $updatestr = "";
        for ($i = 0; $i < count($columns); $i++) {
            if ($updatestr == "") {
                $updatestr = " SET " . $columns[$i] . " = '" . $this->con->real_escape_string($values[$i]) . "'";
            } else {
                $updatestr .= " , " . $columns[$i] . " = '" . $this->con->real_escape_string($values[$i]) . "'";
            }
        }
        if ($condition != "") {
            $condition = " WHERE " . $condition;
        }
        $sql = "UPDATE " . $table . " " . $updatestr . $condition;
        //echo $sql;
        if ($this->con->query($sql)) {
            return $this->con->affected_rows;
        } else {
            return false;
        }
    }

    public function db_get_data($str) {
        $rows = array();
        $result = $this->con->query($str);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function db_get_record($str) {
        $rows = array();
        $result = $this->con->query($str);
        $row = $result->fetch_array();
        return $row;
    }

    public function prepare_param($str) {
        return $this->con->real_escape_string($str);
    }

    public function db_get_rows($str) {
        $result = $this->con->query($str);
        return $this->con->affected_rows;
    }

    public function db_get_Details($str) {
        $row = array();
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row;
    }

}

?>