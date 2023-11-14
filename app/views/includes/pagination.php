<?php if (ceil($total_count / $limit) > 0) : ?>
    <form method="get">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="prev"><button name="page" value="<?php echo $page - 1 ?>">Prev</button></li>
            <?php endif; ?>

            <?php if ($page > 3) : ?>
                <li class="start"><button name="page" value="1">1</button></li>
                <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page - 2 > 0) : ?><li class="page"><button name="page" value="<?php echo $page - 2 ?>"><?php echo $page - 2 ?></button></li><?php endif; ?>
            <?php if ($page - 1 > 0) : ?><li class="page"><button name="page" value="<?php echo $page - 1 ?>"><?php echo $page - 1 ?></button></li><?php endif; ?>

            <li class="current"><button name="page" value="<?php echo $page ?>"><?php echo $page ?></button></li>

            <?php if ($page + 1 < ceil($total_count / $limit) + 1) : ?><li class="page"><button name="page" value="<?php echo $page + 1 ?>"><?php echo $page + 1 ?></button></li><?php endif; ?>
            <?php if ($page + 2 < ceil($total_count / $limit) + 1) : ?><li class="page"><button name="page" value="<?php echo $page + 2 ?>"><?php echo $page + 2 ?></button></li><?php endif; ?>

            <?php if ($page < ceil($total_count / $limit) - 2) : ?>
                <li class="dots">...</li>
                <li class="end"><button name="page" value="<?php echo ceil($total_count / $limit) ?>"><?php echo ceil($total_count / $limit) ?></button></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_count / $limit)) : ?>
                <li class="next"><button name="page" value="<?php echo $page + 1 ?>">Next</button></li>
            <?php endif; ?>
        </ul>
    </form>
<?php endif; ?>