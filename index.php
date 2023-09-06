<?php
include 'conn.php';
if (isset($_POST['btn_submit'])) {
    $task_name = $_POST['task_name'];
    if ($task_name != "") {
        $ins = "INSERT INTO `tbl_tasks`(`task_name`) VALUES ('$task_name')";
        $ins_query = mysqli_query($conn, $ins);
    } else {
        echo "required";
    }
}

if (isset($_GET['task_id'])) {
    echo $task_id = $_GET['task_id'];
    $query = "SELECT * FROM tbl_task WHERE task_id = '$task_id'";
    $query_run = mysqli_query($conn, $query);
    if (mysqli_num_rows($query_run) == 1) {
        $task = mysqli_fetch_assoc($query_run);
        $res = [
            'status' => 200,
            'data' => $task
        ];
        echo json_encode($res);
        return;
    }
}


if (isset($_POST['del_btn'])) {
    $task_id = $_POST['del_btn'];
    $query = mysqli_query($conn, "UPDATE tbl_tasks SET del_status = '1' WHERE task_id = '$task_id'");
    if ($query) {
        header('location:index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>To-Do List</title>
</head>

<body>
    <div class="container-fluid w-50">
        <h2 class="mt-4">To-Do List</h2>
        <form action="" method="post">
            <div class="input-group my-3">
                <input type="text" class="form-control" name="task_name" placeholder="Add your task" aria-describedby="button-addon2" required>
                <button class="btn btn-outline-success btn-lg" type="submit" name="btn_submit" id="button-addon2">Add</button>
            </div>
        </form>
        <?php
        $fetch = "SELECT * FROM tbl_tasks WHERE del_status = '0'";
        $fetch_query = mysqli_query($conn, $fetch);

        if (mysqli_num_rows($fetch_query) > 0) {
        ?>
            <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <th>List</th>
                    <th class="w-25">Action</th>
                </thead>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($fetch_query)) {

                ?>
                    <tbody>
                        <td><?= $i ?></td>
                        <td><?= $row['task_name'] ?></td>
                        <td>
                            <div class="row">
                                <div class="col-3">
                                    <form action="action.php" method="post">
                                        <button type="submit" class="btn btn-warning btn-sm" name="edit_btn" value="<?= $row['task_id'] ?>">
                                            Edit
                                        </button>
                                    </form>
                                </div>
                                <div class="col-3">
                                    <form action="" method="post">
                                        <button type="submit" name="del_btn" class="btn btn-danger btn-sm" value="<?= $row['task_id'] ?>">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    <?php
                    $i++;
                }
                    ?>
                    </tbody>
            </table>
        <?php
        } else {
            echo 'No tasks';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>