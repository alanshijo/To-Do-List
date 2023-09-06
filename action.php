<?php
include 'conn.php';
if (isset($_POST['btn_update'])) {
    $task_id = $_POST['btn_update'];
    $edit_task = $_POST['edit_task'];
    $query = mysqli_query($conn, "UPDATE `tbl_tasks` SET `task_name`='$edit_task', `updated_at` = NOW() WHERE `task_id` = '$task_id'");
    if ($query) {
        header('location:index.php');
    }
}
if (isset($_POST['edit_btn'])) {
    $task_id = $_POST['edit_btn'];
    $fetch = mysqli_query($conn, "SELECT * FROM tbl_tasks WHERE task_id = '$task_id'");
    $row = mysqli_fetch_assoc($fetch);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Edit</title>
    </head>

    <body>
        <div class="container-fluid w-50">
            <form action="" method="POST">
                <div class="mt-4">
                    <input type="text" name="edit_task" value="<?= $row['task_name'] ?>" class="form-control">
                    <button type="submit" name="btn_update" value="<?= $row['task_id'] ?>" class="btn btn-primary mt-2">Update</button>
                </div>
            </form>
        </div>
    </body>

    </html>

<?php
}
