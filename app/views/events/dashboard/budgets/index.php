<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event-dashboard-sponsors" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', $menu_data)  ?>

    <section class="center-section">
            <div class="title-bar">
                <div class="title-wrap">
                    <span class="title">Budget</span>
                    <button onclick="addIncome(event)" class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add Income</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </div>
                <div class="content-section">
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
            </div>
    </section>
</div>

<?php $this->view('includes/modals/event/sponsor')?>
<?php $this->view('includes/modals/event/income')?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>