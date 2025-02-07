<?php
require('controller.php');
include('header.php');

?>

<section id="section">
    <header>
        <h1>
            Add New Candidate
        </h1>
    </header>
    <form action="controller.php" method="post" class="candidate-form">
        <input type="hidden" name="action" value="add_candidate">
        <fieldset class="input-container">
            <div>
                <label for="name">Name</label>
                <input id="name" name="candidate_name" value="<?= $_SESSION['candidate_name'] ?? "" ?>" type="text" placeholder="Enter name">
            </div>
            <span class="error"><?= $_SESSION['candidate_name_err'] ?? "" ?></span>
        </fieldset>
        <fieldset class="input-container">
            <div>
                <label for="email">Email</label>
                <input id="email" name="candidate_email" value="<?= $_SESSION['candidate_email'] ?? "" ?>" type="text" placeholder="Enter email">
            </div>
            <span class="error"><?= $_SESSION['candidate_email_err'] ?? "" ?></span>
        </fieldset>
        <fieldset class="input-container">
            <div>

                <label for="position">Position</label>
                <select name="job_id" id="position">
                    <option value="">Select</option>
                    <?php foreach ($jobs as $job) : ?>
                        <option value="<?= $job['job_id']; ?>">
                            <?= $job['title']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <span class="error"><?= $_SESSION['job_id_err'] ?? "" ?></span>
        </fieldset>
        <div class="submit-button">
            <button type="submit">Submit</button>
        </div>
    </form>
</section>

<?php include('footer.php') ?>