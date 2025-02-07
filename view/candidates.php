<?php
require('controller.php');

include('header.php');
?>

<section id="section" class="long">
    <header class="candidates-header">
        <div class="header-left">
            <h1>Candidates</h1>
            <a href="candidate-form.php">
                <button>Add</button>
            </a>
        </div>
        <form class="filter-form" action="controller.php" method="get">
            <input type="hidden" name="action" value="filter_candidates">
            <select name="filter_status" id="filter">
                <option value="<?= $status ?? "" ?>"><?= $status ?? 'Default' ?></option>
                <?php if (isset($status)) { ?>
                    <option value="">Default</option>
                <?php } ?>
                <?php foreach ($status_arr as $status_el) { ?>
                    <?php if ($status_el !== $status && $status_el !== 'Default') { ?>
                        <option value="<?= $status_el ?>"><?= $status_el ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </header>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Job Applied</th>
                <th>Application Date</th>
                <th>Status</th>
                <th class="actions-th">Actions</th>
            </tr>
            <?php foreach ($candidates as $candidate) : ?>
                <tr>
                    <td><?= $candidate['name']; ?></td>
                    <td><?= $candidate['email']; ?></td>
                    <td><?= $candidate['title']; ?></td>
                    <td><?= $candidate['application_date']; ?></td>
                    <td><?= $candidate['status']; ?></td>
                    <td class="actions-td">
                        <ul>
                            <?php if ($candidate['status'] !== 'Approved') { ?>
                                <li>

                                    <a href="controller.php?action=edit_form&id=<?= $candidate['candidate_id'] ?>">
                                        <button class="action-btn">✏️ Edit</button>

                                    </a>

                                </li>
                                <li>
                                    <?php if ($candidate['status'] !== 'Rejected') { ?>
                                        <form action="controller.php" method="post">
                                            <input type="hidden" name="action" value="approve_candidate">
                                            <input type="hidden" name="candidate_id" value="<?= $candidate['candidate_id'] ?>">
                                            <input type="hidden" name="candidate_name" value="<?= $candidate['name'] ?>">
                                            <input type="hidden" name="candidate_email" value="<?= $candidate['email'] ?>">
                                            <input type="hidden" name="job_title" value="<?= $candidate['title'] ?>">
                                            <input type="hidden" name="job_id" value="<?= $candidate['job_id'] ?>">
                                            <button type="submit" class="action-btn">✅ Approve</button>
                                        </form>
                                    <?php } else { ?>
                                        <form action="controller.php" method="post">
                                            <input type="hidden" name="action" value="return_candidate">
                                            <input type="hidden" name="candidate_id" value="<?= $candidate['candidate_id'] ?>">
                                            <button type="submit" class="action-btn">❓ Return</button>
                                        </form>
                                    <?php } ?>
                                </li>
                                <li>
                                    <?php if ($candidate['status'] !== 'Rejected') { ?>
                                        <form action="controller.php" method="post">
                                            <input type="hidden" name="action" value="reject_candidate">
                                            <input type="hidden" name="candidate_id" value="<?= $candidate['candidate_id'] ?>">
                                            <button type="submit" class="action-btn">❌ Reject</button>
                                        </form>
                                    <?php } ?>

                                </li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include('footer.php') ?>