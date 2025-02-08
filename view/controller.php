<?php
require('../model/database.php');
require('../model/jobs_actions.php');
require('../model/candidates_actions.php');
require('../model/employees_actions.php');
require('../model/dashboard_actions.php');

session_start();


$job_title_err = $candidate_name_err = $candidate_email_err = $job_id_err = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST['job_title'])) {
        $job_title_err = "Title is required";
    } else {
        $job_title = test_input($_POST['job_title']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $job_title)) {
            $job_title_err = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['candidate_name'])) {
        $candidate_name_err = "Name is required";
    } else {
        $candidate_name = test_input($_POST['candidate_name']);
        if (!preg_match("/^[a-zA-Z-'. ]*$/", $candidate_name)) {
            $candidate_name_err = "Only letters and white space allowed";
        }
    }

    if (empty($_POST['candidate_email'])) {
        $candidate_email_err = "Email is required";
    } else {
        $candidate_email = test_input($_POST['candidate_email']);
        if (!filter_var($candidate_email, FILTER_VALIDATE_EMAIL)) {
            $candidate_email_err = "Invalid email format";
        }
    }

    if (empty($_POST['job_id'])) {
        $job_id_err = "Position selection is required";
    } else {
        $job_id = $_POST['job_id'];
    }

    if (isset($_POST['candidate_id'])) {
        $candidate_id = $_POST['candidate_id'];
    }
}


$status_arr = ['Default', 'Pending', 'Rejected'];


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
}

if (
    basename($_SERVER['PHP_SELF']) === 'jobs.php' ||
    basename($_SERVER['PHP_SELF']) === 'candidate-form.php' ||
    basename($_SERVER['PHP_SELF']) === 'edit-form.php'
) {
    if (!isset($_GET['error'])) {

        $_SESSION['job_title_err'] = "";
        $_SESSION['job_title'] = "";
        $_SESSION['candidate_name'] = "";
        $_SESSION['candidate_name_err'] = "";
        $_SESSION['candidate_email'] = "";
        $_SESSION['candidate_email_err'] = "";
        $_SESSION['job_id_err'] = "";
    }

    $jobs = get_jobs();

    if (basename($_SERVER['PHP_SELF']) === 'edit-form.php') {

        $candidate = get_candidate_by_id($_GET['id']);

        foreach ($jobs as $job) {
            if ($job['job_id'] == $candidate['job_id']) {
                $position_title = $job['title'];
            }
        }
    }
}


if (
    basename($_SERVER['PHP_SELF']) === 'candidates.php'
) {
    if (isset($_GET['status'])) {
        $status = htmlspecialchars($_GET['status']);

        $candidates = get_filtered_candidates($status);
    } else {
        $candidates = get_candidates();
    }
}

if (
    basename($_SERVER['PHP_SELF']) === 'employees.php'
) {
    $employees = get_employees();
}

if (
    basename($_SERVER['PHP_SELF']) === 'dashboard.php'
) {
    $logs = get_logs();
    $candidates_count = get_count('candidates');
    $jobs_count = get_count('jobs');
    $employees_count = get_count('new_employees');
}


switch ($action) {
    case "add_job":
        if (!$job_title_err) {
            add_job($job_title);
            add_log("Added job. Title: $job_title");
            header("Location: jobs.php");
        } else {
            $_SESSION['job_title'] = $job_title;
            $_SESSION['job_title_err'] = $job_title_err;
            header("Location: jobs.php?error=1");
        }

        break;
    case "add_candidate":
        if (!$candidate_name_err && !$candidate_email_err && !$job_id_err) {
            add_candidate($candidate_name, $candidate_email, $job_id);
            add_log("Added candidate. Name: $candidate_name");
            header("Location: candidates.php");
        } else {
            $_SESSION['candidate_name'] = $candidate_name;
            $_SESSION['candidate_name_err'] = $candidate_name_err;
            $_SESSION['candidate_email'] = $candidate_email;
            $_SESSION['candidate_email_err'] = $candidate_email_err;
            $_SESSION['job_id_err'] = $job_id_err;
            header("Location: candidate-form.php?error=1");
        }
        break;

    case "edit_form":
        $id = $_GET['id'];
        header("Location: edit-form.php?id=$id");
        break;

    case "edit_candidate":
        if (!$candidate_name_err && !$candidate_email_err && !$job_id_err) {
            update_candidate($candidate_id, $candidate_name, $candidate_email, $job_id);
            add_log("Updated candidate. Name: $candidate_name");
            header("Location: candidates.php");
        } else {
            $_SESSION['candidate_name'] = $candidate_name;
            $_SESSION['candidate_name_err'] = $candidate_name_err;
            $_SESSION['candidate_email'] = $candidate_email;
            $_SESSION['candidate_email_err'] = $candidate_email_err;
            $_SESSION['job_id_err'] = $job_id_err;
            $id = $_GET['id'];
            header("Location: edit-form.php?id=$candidate_id&error=1");
        }
        break;

    case "reject_candidate":
        reject_candidate($candidate_id);
        add_log("Rejected candidate. Candidate Id: $candidate_id");
        header("Location: candidates.php");
        break;

    case "return_candidate":
        return_candidate($candidate_id);
        add_log("Returned candidate. Candidate Id: $candidate_id");
        header("Location: candidates.php");
        break;

    case "approve_candidate":
        approve_candidate($candidate_id, $candidate_name, $candidate_email, $job_id, $job_title);
        add_log("Approved candidate. Name: $candidate_name");
        header("Location: candidates.php");
        break;

    case "filter_candidates":
        $status = $_GET['filter_status'];
        if ($status !== 'Default' && $status !== "") {
            header("Location: candidates.php?status=$status");
        } else {
            header("Location: candidates.php");
        }
        break;
}
