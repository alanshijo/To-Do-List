<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_todo');
if (!$conn) {
    echo 'db not connected!';
}
