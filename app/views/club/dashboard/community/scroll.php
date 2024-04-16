<?php foreach ($messages as $record) {
?>
    <div class="text-wrap">
        <span class="name"><b><?= $record->name ?></b></span>
        <p class="text"><?= $record->message ?></p>
        <span class="datetime">
            <?= displayValue($record->created_datetime, 'datetime') ?>
        </span>
    </div>
<?php } ?>