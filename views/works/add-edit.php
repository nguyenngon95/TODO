<?php include view_path('/layouts/header.php'); ?>

<h1><?= isset($work) ? 'Edit' : 'Add' ?> work</h1>

<?php
    $status = [
        'Planning' => 1,
        'Ongoing' => 2,
        'Complete' => 3
    ];
?>
<div class="content">
    <form method="POST" action="<?= isset($work) ? '/edit/'.$work['id'] : '/add' ?>">
        <div class="error">
            <?php if (isset($error)) : ?>
                <p class="text-error"><?= $error ?></p>
            <?php endif; ?>
        </div>
        <div class="input-group">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" required 
                placeholder="Enter name of work"
                value="<?= isset($work) ? $work['name'] : '' ?>"
            />
        </div>

        <div class="input-group">
            <label for="start_date">Start date: </label>
            <input type="date" id="start_date" name="start_date" required
                value="<?= isset($work) ? $work['start_date'] : '' ?>"
            />
        </div>

        <div class="input-group">
            <label for="end_date">End date: </label>
            <input type="date" id="end_date" name="end_date" required
                value="<?= isset($work) ? $work['end_date'] : '' ?>"
            />
        </div>

        <div class="select-group">
            <label for="status">Status: </label>
            <select id="status" name="status" required>
                <option value="">Select status</option>
                <?php foreach ($status as $key => $value) : ?>
                    <option
                        <?= isset($work) && $work['status'] === $value ? 'selected' : '' ?>
                        value="<?= $value ?>"><?= $key ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="buttons">
            <button type="submit" class="btn btn-info">Save</button>
            <a href="/" class="btn btn-error">Back to list</a>
        </div>
    </form>
</div>

<?php include view_path('/layouts/footer.php'); ?>