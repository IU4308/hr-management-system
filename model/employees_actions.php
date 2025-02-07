<?php

function get_employees()
{
    global $db;
    $query = 'SELECT * FROM new_employees ORDER BY employee_id DESC';
    $statement = $db->prepare($query);
    $statement->execute();
    $employees = $statement->fetchAll();
    $statement->closeCursor();
    return $employees;
}
