<?php include view_path('/layouts/header.php'); ?>
<h1>Calendar of Work</h1>

<a class="btn btn-info" href="/">Back to list</a>

<div id="calendar"></div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
<script>
    let eventData = '<?= json_encode($data) ?>';
    eventData = JSON.parse(eventData);
</script>
<script src='/assets/calendar.js'></script>
<?php include view_path('/layouts/footer.php'); ?>