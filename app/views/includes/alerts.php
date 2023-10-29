<head>
    <script src="<?= ROOT ?>/assets/js/alerts.js"></script>
</head>

<?php if (!empty($_SESSION) && !empty($_SESSION['alerts']) && is_array($_SESSION)) {
    foreach ($_SESSION['alerts'] as $x => $val) {
?>
        <div data-status=<?= $val["status"] ?> class="alert">
            <span class="message"><?= $val["message"] ?></span>
            <span onclick="onAlertClose(event)" class="material-icons-outlined icon">
                close
            </span>
        </div>
<?php }
} ?>