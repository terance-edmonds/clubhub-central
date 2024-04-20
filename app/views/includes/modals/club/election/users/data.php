<div class="table-wrap w-max">
    <table>
        <tr class="table-header">
            <th class="checkbox-col">
                <input onclick="onSelectAll(event)" type="checkbox" name="select_all_checkbox" class="checkbox pointer-cursor">
            </th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Joined On</th>
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
                    <input onclick="onAddMember(event, '<?= $val->id ?>', '<?= $val->user_id ?>', '<?= $val->first_name ?> <?= $val->last_name ?>')" data-value="<?= $val->id ?>" type="checkbox" name="user_select_checkbox" class="checkbox pointer-cursor" />
                </td>
                <td>
                    <?= displayValue($val->first_name) ?>
                </td>
                <td>
                    <?= displayValue($val->last_name) ?>
                </td>
                <td>
                    <?= displayValue($val->email) ?>
                </td>
                <td align="center">
                    <script>
                        document.write(moment('<?= $val->joined_datetime ?>').tz(Intl.DateTimeFormat().resolvedOptions().timeZone).format('yyyy-MM-DD'));
                    </script>
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