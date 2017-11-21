<?php

include_once("dbcon/database.php");

class DBCommon {

    private $dbobj;
    private $colsPtype = array("name", "status", "entrydate");
    private $colsFtype = array("name", "status", "entrydate");

    function __construct() {
        $this->dbobj = new DBConnection();
    }

    public function commonInsert($table, $cols, $values) {
        $insert = $this->dbobj->db_insert($table, $values, $cols);
        return $insert;
    }

    public function commonGetDetails($query) {
        $data = $this->dbobj->db_get_Details($query);
        return $data;
    }

    public function commonGetData($query) {
        $data = $this->dbobj->db_get_data($query);
        return $data;
    }

    public function commonUpdate($table, $cols, $values, $cond) {
        $ups_value = $this->dbobj->db_update($table, $cols, $values, $cond);
        return $ups_value;
    }

    public function updateUsers($values, $cond) {
        $this->table = "users";
        $update = $this->dbobj->db_update($this->table, $this->colsUser, $values, $cond);
        return $update;
    }

    public function deleteData($table, $values, $cond) {
        $delete = $this->dbobj->db_delete($table, $cond);
        return $delete;
    }

    public function insertBlog($values) {
        $this->table = "blog";
        $insert = $this->dbobj->db_insert($this->table, $values, $this->colsBlog);
        return $insert;
    }

    public function updateBlog($values, $cond) {
        $this->table = "blog";
        $update = $this->dbobj->db_update($this->table, $this->colsBlog, $values, $cond);
        return $update;
    }

    public function updateBlogStatus($values, $cond) {
        $this->table = "blog";
        $colsUserstatus = array("status");
        $supdate = $this->dbobj->db_update($this->table, $colsUserstatus, $values, $cond);
        return $supdate;
    }

    public function getFeedback($id) {
        if ($id != '') {
            $str = "select * from feedback where id = " . $id . " order by id desc";
            $gdata = $this->dbobj->db_get_Details($str);
            return $gdata;
        } else {
            $str = "select fb.*,pr.name pname, pr.pimage from feedback fb inner join project pr on fb.project_id=pr.id order by fb.id desc";
            $gdata = $this->dbobj->db_get_data($str);
            return $gdata;
        }
    }

}

$commondata = new DBCommon();
?>		

