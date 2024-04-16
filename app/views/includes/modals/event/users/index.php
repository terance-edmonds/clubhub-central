<div class="popup-modal-wrap" popup-name="select-event-users">
    <div class=" popup-modal" popup-size="l">
        <div class="popup-header">
            <span class="title">Select Users</span>
            <div class="icon" onclick="$(`[popup-name='select-event-users']`).popup(false)">
                <span class="material-icons-outlined">
                    close
                </span>
            </div>
        </div>
        <div class="popup-body">
            <div class="search-input">
                <div class="input-wrap">
                    <div class="input">
                        <div class="icon-button">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                        </div>
                        <input onkeyup="onSearch(event)" type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                        <?php $this->view('includes/loaders/data-loader'); ?>
                    </div>
                </div>
            </div>
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
                    <?php if (count($table_data) == 0) { ?>
                        <tr>
                            <td colspan="6">No Records.</td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($table_data as $x => $val) {
                    ?>
                        <?php $json = json_encode($val); ?>
                        <tr class="table-data table-align">
                            <td class="checkbox-col">
                                <input onclick="onAddMember(<?= $val->user_name ?>, <?= $val->id ?>)" type="checkbox" name="select-all" class="checkbox pointer-cursor" />
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
                    "total_count" => $total_count,
                    "limit" => $limit,
                    "page" => $page,
                ]) ?>
            </div>
        </div>
    </div>
</div>