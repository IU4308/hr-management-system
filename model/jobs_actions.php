<?php


function add_job($title)
{
    global $db;
    $query = 'INSERT INTO jobs (title)
                 VALUES (:title)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':title', $title);
    $stmt->execute();
    $stmt->closeCursor();
}

function get_jobs()
{
    global $db;
    $query = 'SELECT * FROM jobs ORDER BY job_id';
    $statement = $db->prepare($query);
    $statement->execute();
    $jobs = $statement->fetchAll();
    $statement->closeCursor();
    return $jobs;
}

function get_count_by_id($job_id, $database)
{
    global $db;
    $query = "SELECT COUNT(*) FROM $database WHERE job_id = $job_id;";
    $statement = $db->prepare($query);
    $statement->execute();
    $count_arr = $statement->fetchAll();
    $count = $count_arr[0][0];
    $statement->closeCursor();
    return $count;
}
