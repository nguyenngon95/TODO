<?php include view_path('/layouts/header.php'); ?>
<h1>TO DO LIST</h1>

<div class="header-list">
    <a href="/add" class="btn btn-add">Add work</a>
</div>

<div class="div-table">
    <table class="table">
        <thead>
            <tr>
                <th>Work</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $work) { ?>
            <tr>
                <td><?= $work['name'] ?></td>
                <td><?= $work['start_date'] ?></td>
                <td><?= $work['end_date'] ?></td>
                <td><?= $work['status'] === 1 ? 'Planning' : ($work['status'] === 2 ? 'Doing' : 'Complete') ?></td>
                <td>
                    <a class="btn btn-info" href="/edit/<?= $work['id'] ?>">Edit</a>
                    <a class="btn btn-error" href="/delete/<?= $work['id'] ?>"
                        onclick="return confirm('Do you want to delete this work(ID: <?= $work['id'] ?>)?')">
                        Delete
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include view_path('/layouts/footer.php'); ?>