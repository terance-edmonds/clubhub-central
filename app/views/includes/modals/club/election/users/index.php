<div class="popup-modal-wrap" popup-name="select-member-users">
    <div class=" popup-modal" popup-size="l">
        <div class="popup-header">
            <span class="title">Select Users</span>
            <div class="icon" onclick="$(`[popup-name='select-member-users']`).popup(false)">
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
                        <input id="users_search" onkeyup="onSearch(event)" type="text" placeholder="Search" name="search" value="<?= setValue('search', '', 'text', 'get') ?>">
                        <?php $this->view('includes/loaders/data-loader'); ?>
                    </div>
                </div>
            </div>
            <?php $this->view('includes/modals/club/election/users/data', ["select_users" => [
                "table_data" => $table_data,
                "total_count" => $total_count,
                "limit" => $limit,
                "page" => $page,
            ]]) ?>
        </div>
    </div>
</div>