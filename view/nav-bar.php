<?php
function printClassName($fileName)
{
    if (basename($_SERVER['PHP_SELF']) === $fileName) {
        echo "active";
    }
}
?>

<section class="nav-bar">
    <header>
        <a href="..">
            <h1>HRMS</h1>
        </a>
    </header>
    <nav>
        <ul>
            <a href="dashboard.php">
                <li
                    class="<?php printClassName("dashboard.php") ?>">
                    Dashboard
                </li>
            </a>
            <a href="jobs.php">
                <li
                    class="<?php printClassName("jobs.php") ?>">
                    Jobs
                </li>
            </a>
            <a href="candidates.php">
                <li
                    class="<?php printClassName("candidates.php") ?>">
                    Candidates
                </li>
            </a>
            <a href="employees.php">
                <li
                    class="<?php printClassName("employees.php") ?>">
                    Approved
                </li>
            </a>
        </ul>
    </nav>
</section>