<?php
require('controller.php');

include('header.php');
?>


<section id="section" class="short">
    <header class="header">
        <h1>Jobs </h1>

    </header>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Title</th>
                <th>Applied</th>
                <th>Employed</th>
            </tr>
            <?php foreach ($jobs as $job) : ?>
                <tr>
                    <td><?= $job['title']; ?></td>
                    <td><?= get_count_by_id($job['job_id'], 'candidates') ?></td>
                    <td><?= get_count_by_id($job['job_id'], 'new_employees') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form action="controller.php" method="post" class="table-form">
            <input type="hidden" name="action" value="add_job">
            <fieldset class="add-job">
                <label for="job_title">Add a Position</label>
                <input type="text" id="job_title" name='job_title' value="<?= $_SESSION['job_title'] ?? "" ?>" class="table-input">
            </fieldset>
            <button type="submit">Add</button>
        </form>
        <span class="error"><?= $_SESSION['job_title_err'] ?? "" ?></span>
    </div>
</section>

<?php include('footer.php') ?>