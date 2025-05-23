<?php

function insert_task($conn, $data)
{
    $sql = "INSERT INTO tasks (title, description, assigned_to) VALUES(?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function get_all_tasks($conn)
{
    $sql = "SELECT * FROM tasks ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = 0;
    }
    return $tasks;
}


function delete_task($conn, $data){
    $sql = "DELETE FROM tasks WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt-> execute($data);
}

function get_task_by_id($conn, $id) {
    $sql = "SELECT * FROM tasks WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0) {
        $task = $stmt->fetch();
    }else {$task=0;}

    return $task;
}

function update_task($conn, $data) {
    $sql = "UPDATE tasks SET title=?, description=?, assigned_to=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}