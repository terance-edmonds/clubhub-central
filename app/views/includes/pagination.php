<?php
$param_name = 'page';
if (!empty($page_name)) $param_name = $page_name;
?>

<?php if (ceil($total_count / $limit) > 0) { ?>
    <ul class="pagination">
        <?php if ($page > 1) { ?>
            <li class="prev"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page - 1 ?>">Prev</button></li>
        <?php } ?>

        <?php if ($page > 3) { ?>
            <li class="start"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="1">1</button></li>
            <li class="dots">...</li>
        <?php } ?>

        <?php if ($page - 2 > 0) { ?><li class="page"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page - 2 ?>"><?php echo $page - 2 ?></button></li><?php } ?>
        <?php if ($page - 1 > 0) { ?><li class="page"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page - 1 ?>"><?php echo $page - 1 ?></button></li><?php } ?>

        <li class="current"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page ?>"><?php echo $page ?></button></li>

        <?php if ($page + 1 < ceil($total_count / $limit) + 1) { ?><li class="page"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page + 1 ?>"><?php echo $page + 1 ?></button></li><?php } ?>
        <?php if ($page + 2 < ceil($total_count / $limit) + 1) { ?><li class="page"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page + 2 ?>"><?php echo $page + 2 ?></button></li><?php } ?>

        <?php if ($page < ceil($total_count / $limit) - 2) { ?>
            <li class="dots">...</li>
            <li class="end"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo ceil($total_count / $limit) ?>"><?php echo ceil($total_count / $limit) ?></button></li>
        <?php } ?>

        <?php if ($page < ceil($total_count / $limit)) { ?>
            <li class="next"><button onclick="addParamToUrl(event)" name="<?= $param_name ?>" value="<?php echo $page + 1 ?>">Next</button></li>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (empty($script_included)) { ?>
    <script src="<?= ROOT ?>/assets/js/pagination.js"></script>
<?php } ?>