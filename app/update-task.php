<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin') {

        include "../DB_connection.php";

        function validate_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $title = validate_input($_POST['title']);
        $description = validate_input($_POST['description']);
        $assigned_to = validate_input($_POST['assigned_to']);
        $id = validate_input($_POST['id']);

        if (empty($title)) {
            $em = urlencode("Title is required");
            $description = urlencode($description); // may be empty
            header("Location: ../edit-task.php?error=$em&id=$id&description=$description");
            exit();
        } elseif (empty($description)) {
            $em = urlencode("Description is required");
            $title = urlencode($title); // already validated
            header("Location: ../edit-task.php?error=$em&id=$id&title=$title");
            exit();
        } elseif ($assigned_to == '0') {
            $em = urlencode("Please select an employee to assign the task");
            $title = urlencode($title);
            $description = urlencode($description);
            header("Location: ../edit-task.php?error=$em&id=$id&title=$title&description=$description");
            exit();

        } else {
            include "Model/Task.php";
            $data = array($title, $description, $assigned_to, $id);
            update_task($conn, $data);

            $em = "Task updated successfully";
            header("Location: ../edit-task.php?success=$em&id=$id");
            exit();
        }

    } else {
        $em = "Unknown error";
        header("Location: ../edit-task.php?error=$em");
        exit();
    }

} else {
    $em = "First LOGIN";
    header("Location: ../login.php?error=$em");
    exit();
}
