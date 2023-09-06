<?php
include 'conn.php';
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
        <button class="btn btn-outline-success my-3 px-4" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="add_form">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" class="form-control" name="task_name" id="task_name" placeholder="Enter the task name here">
                            </div>
                            <div class="mb-3">
                                <label for="task_desc" class="form-label">Task Description</label>
                                <textarea class="form-control" name="task_desc" id="task_desc" rows="3" placeholder="Enter the task description here..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="table_todo">
            <?php
            $fetch = "SELECT * FROM tbl_tasks WHERE del_status = '0'";
            $fetch_query = mysqli_query($conn, $fetch);

            ?>
            <table class="table table-bordered">
                <thead>
                    <th>Task Name</th>
                    <th>Task Description</th>
                    <th class="w-25">Actions</th>
                </thead>
                <tbody>
                    <?php

                    if (mysqli_num_rows($fetch_query) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($fetch_query)) {

                    ?>
                            <tr>
                                <td><?= $row['task_name'] ?></td>
                                <td><?= $row['task_desc'] ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-3">
                                            <button type="submit" class="btn btn-warning btn-sm" name="edit_btn" id="edit_btn" value="<?= $row['task_id'] ?>">
                                                Edit
                                            </button>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name="del_btn" class="btn btn-danger btn-sm" id="del_btn" value="<?= $row['task_id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                    } else {
                        ?>
                </tbody>
            <?php
                        echo "<p>No tasks</p>";
                    }
            ?>
            </table>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edit_form">
                        <input type="hidden" name="edit_task_id" id="edit_task_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" class="form-control" name="edit_task_name" id="edit_task_name" placeholder="Enter the task name here">
                            </div>
                            <div class="mb-3">
                                <label for="task_desc" class="form-label">Task Description</label>
                                <textarea class="form-control" name="edit_task_desc" id="edit_task_desc" rows="3" placeholder="Enter the task description here..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('submit', '#add_form', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("add_todo", true);

            $.ajax({
                type: "POST",
                url: "action.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {

                        $('#addModal').modal('hide');
                        $('#add_form')[0].reset();

                        $('#table_todo').load(location.href + " #table_todo");

                    }
                }
            });

        });

        $(document).on('click', '#edit_btn', function() {

            var task_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "action.php?task_id=" + task_id,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        $('#edit_task_id').val(res.data.task_id);
                        $('#edit_task_name').val(res.data.task_name);
                        $('#edit_task_desc').val(res.data.task_desc);
                        $('#editModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#edit_form', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("edit_todo", true);

            $.ajax({
                type: "POST",
                url: "action.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {

                        $('#editModal').modal('hide');
                        $('#edit_form')[0].reset();

                        $('#table_todo').load(location.href + " #table_todo");

                    }
                }
            });

        });


        $(document).on('click', '#del_btn', function(e) {
            e.preventDefault();

            if (confirm('Are you sure you want to delete this task?')) {
                var task_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: {
                        'delete_task': true,
                        'task_id': task_id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 200) {

                            $('#table_todo').load(location.href + " #table_todo");
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>