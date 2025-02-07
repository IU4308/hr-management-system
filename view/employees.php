<?php
require('controller.php');

include('header.php');
?>

<section id="section" class="long">
    <header>
        <h1>New Employees</h1>
    </header>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Employement Date</th>
            </tr>

            <?php foreach ($employees as $employee) : ?>
                <tr>
                    <td><?= $employee['name']; ?></td>
                    <td><?= $employee['email']; ?></td>
                    <td><?= $employee['position']; ?></td>
                    <td><?= $employee['employment_date']; ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>
</section>

<?php include('footer.php') ?>