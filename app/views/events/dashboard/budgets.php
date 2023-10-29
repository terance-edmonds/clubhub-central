<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-budgets" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Budget</span>
            </div>
        </div>

        <div class="summary-section">
            <p class="title">Summary</p>

            <div class="cards-section">
                <div class="summary-card">
                    <div class="top-bar">
                        <div class="icon-wrap">
                            <span class="material-icons-outlined">
                                move_to_inbox
                            </span>
                        </div>
                        <p class="card-title">Income</p>
                    </div>

                    <p class="amount green">LKR 200,000</p>
                </div>
                <div class="summary-card">
                    <div class="top-bar">
                        <div class="icon-wrap">
                            <span class="material-icons-outlined">
                                outbox
                            </span>
                        </div>
                        <p class="card-title">Expenses</p>
                    </div>

                    <p class="amount red">LKR 200,000</p>
                </div>
                <div class="summary-card">
                    <div class="top-bar">
                        <div class="icon-wrap">
                            <span class="material-icons-outlined">
                                currency_exchange
                            </span>
                        </div>
                        <p class="card-title">Net Profit / Loss</p>
                    </div>

                    <p class="amount green">LKR 200,000</p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="actions-wrap">
                <div class="action-buttons">
                    <a class="action-link" data-active="<?php if ($tab == 'income') echo 'true'; ?>" href="<?= ROOT ?>/events/dashboard/budgets?tab=income"><button class="button">Income</button></a>
                    <a class="action-link" data-active="<?php if ($tab == 'expense') echo 'true'; ?>" href="<?= ROOT ?>/events/dashboard/budgets?tab=expense"><button class="button">Expense</button></a>
                </div>

                <div class="action-search">
                    <div class="input-wrap search-input">
                        <div class="input">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                            <input type="text" placeholder="Search">
                        </div>
                    </div>

                    <button onclick="$(`[popup-name='add-<?= $tab ?>']`).popup(true)" class="button w-content" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add New</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th>Transaction Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>From</th>
                        <th>Payment Type</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data table-align">
                        <td>Freshers'day</td>
                        <td>For Decorations</td>
                        <td>20,000</td>
                        <td>WSO2</td>
                        <td>Cash</td>
                        <td>
                            <div class="buttons">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        edit
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        delete
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-data table-align">
                        <td>Freshers'day</td>
                        <td>For Decorations</td>
                        <td>20,000</td>
                        <td>WSO2</td>
                        <td>Cheque</td>
                        <td>
                            <div class="buttons">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        edit
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        delete
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-data table-align">
                        <td>Freshers'day</td>
                        <td>For Decorations</td>
                        <td>20,000</td>
                        <td>WSO2</td>
                        <td>Cash</td>
                        <td>
                            <div class="buttons">
                                <button class="icon-button">
                                    <span class="material-icons-outlined">
                                        edit
                                    </span>
                                </button>
                                <button class="icon-button cl-red">
                                    <span class="material-icons-outlined">
                                        delete
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>

<?php $this->view('includes/modals/event/expense') ?>
<?php $this->view('includes/modals/event/income') ?>

<?php if (!empty($popups["add-income"])) { ?>
    <script>
        $(`[popup-name='add-<?= $tab ?>']`).popup(true)
    </script>
<?php } ?>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>