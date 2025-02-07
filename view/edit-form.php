<?php
require('controller.php');
include('header.php');

?>

<section id="section">
    <header>
        <h1>
            Edit the candidate
        </h1>
    </header>
    <form action="controller.php" method="post" class="candidate-form">
        <input type="hidden" name="action" value="edit_candidate">
        <input type="hidden" name="candidate_id" value="<?= $candidate['candidate_id'] ?>">
        <fieldset class="input-container">
            <div>
                <label for="name">Name</label>
                <input id="name" value="<?= $candidate['name'] ?>" name="candidate_name" type="text" placeholder="Enter name">
            </div>
            <span class="error"><?= $_SESSION['candidate_name_err'] ?? "" ?></span>
        </fieldset>
        <fieldset class="input-container">
            <div>
                <label for="email">Email</label>
                <input id="email" value="<?= $candidate['email'] ?>" name="candidate_email" type="text" placeholder="Enter email">
            </div>
            <span class="error"><?= $_SESSION['candidate_email_err'] ?? "" ?></span>

        </fieldset>
        <fieldset class="input-container">
            <div>
                <label for="position">Position</label>
                <select name="job_id" id="position">
                    <option value="<?= $candidate['job_id'] ?>"><?= $position_title ?></option>
                    <?php foreach ($jobs as $job) : ?>
                        <?php if ($job['job_id'] !== $candidate['job_id']) { ?>
                            <option value="<?= $job['job_id']; ?>">
                                <?= $job['title']; ?>
                            </option>
                        <?php } ?>
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