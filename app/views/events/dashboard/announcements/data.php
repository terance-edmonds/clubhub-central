<div class="table-wrap w-max">
    <table>
        <tr class="table-header">
            <th class="checkbox-col">
                <input type="checkbox" name="select-all" class="checkbox pointer-cursor">
            </th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
        </tr>
        <?php if (count($select_users['table_data']) == 0) { ?>
            <tr>
                <td colspan="6">No Records.</td>
            </tr>
        <?php } ?>
        <?php foreach ($select_users['table_data'] as $x => $val) {
        ?>
            <?php $json = json_encode($val); ?>
            <tr class="table-data table-align">
                <td class="checkbox-col">
                    <input type="checkbox" name="select-all" class="checkbox pointer-cursor">
                </td>
                <td>
                    <?= displayValue($val->user_name) ?>
                </td>
                <td>
                    <?= displayValue($val->user_email) ?>
                </td>
                <td>
                    <?= displayValue($val->user_contact) ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php $this->view('includes/pagination', [
        "total_count" => $select_users['total_count'],
        "limit" => $select_users['limit'],
        "page" => $select_users['page'],
    ]) ?>
</div>