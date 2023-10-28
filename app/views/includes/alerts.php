<head>
    <script src="<?= ROOT ?>/assets/js/alerts.js"></script>
</head>

<?php if (!empty($alerts) && is_array($alerts)) {
    foreach ($alerts as $x => $val) {
?>
        <div data-status=<?= $val["status"] ?> class="alert">
            <span class="message"><?= $val["message"] ?></span>
            <span onclick="onAlertClose(event)" class="material-icons-outlined icon">
                close
            </span>
        </div>
<?php }
} ?>