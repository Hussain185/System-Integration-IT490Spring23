<?php
session_start();
//$usersUid = $_COOKIE['username'];
    class Tasks {
        
        //Function to insert data
        public function executeQuery($sql) {
            //$res = $this->connect()->query($sql);
            $res = mysqli_query(dbConnection(), $sql);
            if($res)
                return true;
            else
                return false;
        }

        // Function to get all tasks
        public function getAllTasks() {
            $usersUid = $_COOKIE['username'];
            $sql = "select * from todolists WHERE usersUid = '{$usersUid}' order by id desc";
            //$result = $this->connect()->query($sql);
            $result = mysqli_query(dbConnection(), $sql);

            $data = array();
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            return $data;
        }

        // Function to get all tasks
        public function getTask($id) {
            $sql = "select * from todolists where id = '{$id}'";
            $result = mysqli_query(dbConnection(), $sql);

            $data = array();
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data = $row;
                }
            }
            return $data;
        }


    }
?>