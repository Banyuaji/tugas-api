<?php
    include("../connect/connection.php");
    $db = new dataObj();
    $connection = $db->getConnstring();
    $request_method = $_SERVER["REQUEST_METHOD"];

    switch ($request_method) {
        case 'GET':
            if(!empty($_GET['id'])) {
                $id = intval($_GET['id']);
                get_pegawaid($id);
            } else {
                get_pegawai();
            }
            break;

        case 'POST':
            insert_pegawai();
            break;

        case 'PUT':
            $id = intval($_GET['id']);
            update_pegawai($id);
            break;
    
        case 'DELETE':
            $id = intval($_GET['id']);
            del_pegawai($id);
            break;

        default:
            header("");
            break;
    }

    function get_pegawai() {
        global $connection;
        $query = "SELECT * FROM `pegawai`";
        $resp = array();
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($res)) {
            $resp[]=$row;
        }
        header('Content-type:application/json');
        echo json_encode($resp);
    }

    function get_pegawaid($id=0) {
        global $connection;
        $query = "SELECT * FROM `pegawai`";
        if ($id != 0) {
            $query.= "WHERE id = '$id' LIMIT 1";
        }
        $resp = array();
        $res =  mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($res)) {
            $resp[] = $row;
        }
        header('Content-type:application/json');
        echo json_encode($resp);
    }

    function insert_pegawai() {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $name = $data["name"];
        $salary = $data["salary"];
        $age = $data["age"];
        echo $query = "INSERT INTO `pegawai` SET
        `id` = null,
        `name`='$name',
        `salary`='$salary',
        `age`='$age'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status'=> 1,
                'status_message'=>'Employee Added Successfully.'
            );
        } else {
            $resp = array(
                'status'=> 0,
                'status_message'=> 'Employee Addition Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    } 

    function update_pegawai($id) {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $name = $data["name"];
        $salary = $data["salary"];
        $age = $data["age"];
        echo $query = "UPDATE `pegawai` SET
        `name` = '$name',
        `salary` = '$salary',
        `age` = '$age' WHERE `id` = '$id'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status' => 1,
                'status_message' => 'Employee Updated Successfully.'
            );
        } else {
            $resp = array(
                'status' => 0,
                'status_message' => 'Employee Update Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    }

    function del_pegawai($id) {
        global $connection;
        $query = "DELETE FROM `pegawai` WHERE `id`='$id'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status' => 1,
                'status_message' => 'Employee Deleted Successfully.'
            );
        } else {
            $resp = array(
                'status' => 0,
                'status_message' => 'Employee Delete Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
?>