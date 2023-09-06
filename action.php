<?php
include 'conn.php';
if (isset($_POST['add_todo'])) {

    $task_name = $_POST['task_name'];
    $task_desc = $_POST['task_desc'];
    $query = "INSERT INTO `tbl_tasks`(`task_name`, `task_desc`) VALUES ('$task_name', '$task_desc')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_GET['task_id'])) {
    $task_id = mysqli_real_escape_string($conn, $_GET['task_id']);

    $query = "SELECT * FROM tbl_tasks WHERE task_id='$task_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $tasks = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'data' => $tasks
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['edit_todo'])) {

    $task_id = $_POST['edit_task_id'];
    $task_name = $_POST['edit_task_name'];
    $task_desc = $_POST['edit_task_desc'];
    $query = "UPDATE `tbl_tasks` SET `task_name` = '$task_name', `task_desc` = '$task_desc' WHERE `task_id` = '$task_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200
        ];
        echo json_encode($res);
        return;
    }
}
if (isset($_POST['delete_task'])) {
    $task_id = mysqli_real_escape_string($conn, $_POST['task_id']);

    $query = "UPDATE tbl_tasks SET `del_status` = '1' WHERE `task_id` = '$task_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200
        ];
        echo json_encode($res);
        return;
    }
}
