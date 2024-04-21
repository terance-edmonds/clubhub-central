<?php foreach ($messages as $record) {
?>
    <div class="text-wrap">
        <span class="name"><b><?= $record->name ?></b> <span class="role"><small>( <?= displayValue($record->role, 'snake_title') ?> )</small></span></span>
        <p class="text"><?= $record->message ?></p>
        <span class="datetime">
            <?= displayValue($record->created_datetime, 'datetime') ?>
        </span>
    </div>
<?php } ?>