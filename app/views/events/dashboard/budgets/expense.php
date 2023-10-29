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
                    <button  class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Income</span>
                    </button>
                    <button  class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Expense</span>
                    </button>
                    <div class="input-wrap search-input">
                        <div class="input">
                            <span class="icon material-icons-outlined">
                                search
                            </span>
                            <input type="text" placeholder="Search">
                        </div>
                    </div>
                    <button onclick="addExpense(event)" class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add Expense</span>
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
                                <th>To</th>
                                <th>Payment Type</th>
                                <th>Actions</th>
                            </tr>
                            <tr class="table-data table-align">
                                <td>Tents for TOC</td>
                                <td>For building tents in grounds </td>
                                <td>20,000</td>
                                <td>unix</td>
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
                                <td>Tents for TOC</td>
                                <td>For building tents in grounds </td>
                                <td>20,000</td>
                                <td>unix</td>
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
                                <td>Tents for TOC</td>
                                <td>For building tents in grounds </td>
                                <td>20,000</td>
                                <td>unix</td>
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

<?php $this->view('includes/modals/event/expense')?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>