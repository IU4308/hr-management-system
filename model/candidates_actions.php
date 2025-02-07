<?php

function add_candidate($name, $email, $job_id)
{
    global $db;
    $query = 'INSERT INTO candidates (name, email, job_id)
              VALUES
                 (:name, :email, :job_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':job_id', $job_id);
    $statement->execute();
    $statement->closeCursor();
}


function get_candidates()
{
    global $db;
    $query = 'SELECT A.candidate_id, A.name, A.email, A.application_date, A.status, A.job_id, C.title FROM candidates A  LEFT JOIN jobs C ON A.job_id = C.job_id ORDER BY A.candidate_id DESC';
    $statement = $db->prepare($query);
    $statement->execute();
    $candidates = $statement->fetchAll();
    $statement->closeCursor();
    return $candidates;
}
function get_filtered_candidates($filter)
{
    global $db;
    $query = 'SELECT A.candidate_id, A.name, A.email, A.application_date, A.status, A.job_id, C.title FROM candidates A LEFT JOIN jobs C ON A.job_id = C.job_id WHERE A.status = :filter ORDER BY A.candidate_id DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':filter', $filter);
    $statement->execute();
    $candidates = $statement->fetchAll();
    $statement->closeCursor();
    return $candidates;
}

function get_candidate_by_id($id)
{
    global $db;
    $query = "SELECT candidate_id, name, email, job_id FROM candidates WHERE candidate_id = $id";
    $statement = $db->prepare($query);
    $statement->execute();
    $candidate = $statement->fetch();
    $statement->closeCursor();
    return $candidate;
}

function update_candidate($id, $name, $email, $job_id)
{
    global $db;
    $query = "UPDATE candidates
              SET name = :name, email = :email, job_id = :job_id
              WHERE candidate_id = :candidate_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':job_id', $job_id);
    $statement->bindValue(':candidate_id', $id);
    $statement->execute();
    $statement->closeCursor();
}

function approve_candidate($id, $name, $email, $job_id, $position)
{
    global $db;
    $query_candidates = "
        DELETE FROM candidates
        WHERE candidate_id = :id;
    ";

    $query_employees = '
        INSERT INTO new_employees (name, email, job_id, position)
        VALUES (:name, :email, :job_id, :position);
    ';

    $statement_candidates = $db->prepare($query_candidates);
    $statement_candidates->bindValue(':id', $id);
    $statement_candidates->execute();
    $statement_candidates->closeCursor();

    $statement_employees = $db->prepare($query_employees);
    $statement_employees->bindValue(':name', $name);
    $statement_employees->bindValue(':email', $email);
    $statement_employees->bindValue(':job_id', $job_id);
    $statement_employees->bindValue(':position', $position);
    $statement_employees->execute();
    $statement_employees->closeCursor();
}

function reject_candidate($id)
{
    global $db;
    $query = "UPDATE candidates
              SET status = 'Rejected'
              WHERE candidate_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

function return_candidate($id)
{
    global $db;
    $query = "UPDATE candidates
              SET status = 'Pending'
              WHERE candidate_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}
