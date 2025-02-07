<?php
require('controller.php');

include('header.php');
?>

<section id="section" class="dashboard">
    <header>
        <h1>Dashboard</h1>
    </header>

    <div class="cards-container">
        <div class="card">
            <h2>
                Candidates
            </h2>
            <div><?= $candidates_count ?></div>
            <a href="candidate-form.php">
                <button>Add</button>
            </a>
        </div>
        <div class="card">
            <h2>
                Available Jobs
            </h2>
            <div><?= $jobs_count ?></div>
        </div>
        <div class="card ">
            <h2>
                New Employees
            </h2>
            <div><?= $employees_count ?></div>
        </div>
    </div>

    <h2>Recent activity</h2>
    <div class="logs">
        <table>
            <tr>
                <th>Timestamp</th>
                <th>Message</th>
            </tr>
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td class="timestamp"><?= $log['log_date'] ?></td>
                    <td class="message"><?= $log['message'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include('footer.php') ?>