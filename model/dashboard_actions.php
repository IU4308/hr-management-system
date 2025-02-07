<?php

function get_count($database)
{
    global $db;
    $query = "SELECT COUNT(*) FROM $database;";
    $statement = $db->prepare($query);
    $statement->execute();
    $count_arr = $statement->fetch();
    $count = $count_arr[0];
    $statement->closeCursor();
    return $count;
}

function add_log($message)
{
    global $db;
    $query = 'INSERT INTO logs (message) VALUES (:message);';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':message', $message);
    $stmt->execute();
    $stmt->closeCursor();
}

function get_logs()
{
    global $db;
    $query = "SELECT * FROM logs ORDER BY log_id DESC;";
    $statement = $db->prepare($query);
    $statement->execute();
    $logs = $statement->fetchAll();
    $statement->closeCursor();
    return $logs;
}
