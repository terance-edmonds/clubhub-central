<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event-dashboard-sponsors" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Packages</span>
                <button onclick="addPackage(event)" class="button" data-variant="outlined" data-type="icon" data-size="small">
                    <span>Add Package</span>
                    <span class="material-icons-outlined">
                        add
                    </span>
                </button>
            </div>

            <div class="input-wrap search-input">
                <div class="input">
                    <span class="icon material-icons-outlined">
                        search
                    </span>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="table-wrap">
                <table>
                    <tr class="table-header">
                        <th align="left">Package Name</th>
                        <th align="left">Amount</th>
                        <th align="left">Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>Platinum</td>
                        <td>200,000</td>
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
                    <tr class="table-data">
                        <td>Gold</td>
                        <td>100,000</td>
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
                    <tr class="table-data">
                        <td>Silver</td>
                        <td>50,000</td>
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



            <div class="title-bar">
                <div class="title-wrap">
                    <span class="title">Sponsors</span>
                    <button onclick="addSponsor(event)" class="button contained" class="button" data-variant="outlined" data-type="icon" data-size="small">
                        <span>Add Sponsor</span>
                        <span class="material-icons-outlined">
                            add
                        </span>
                    </button>
                </div>
                <div class="content-section">
                    <div class="table-wrap">
                        <table>
                            <tr class="table-header">
                                <th>Sponser Name</th>
                                <th>Contact Person</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            <tr class="table-data">
                                <td>WSO2</td>
                                <td>Terence Edmonds</td>
                                <td>0777123456</td>
                                <td>terence@gmail.com</td>
                                <td>2,000,000</td>
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
                            <tr class="table-data">
                                <td>WSO2</td>
                                <td>Terence Edmonds</td>
                                <td>0777123456</td>
                                <td>terence@gmail.com</td>
                                <td>2,000,000</td>
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
                            <tr class="table-data">
                                <td>WSO2</td>
                                <td>Terence Edmonds</td>
                                <td>0777123456</td>
                                <td>terence@gmail.com</td>
                                <td>2,000,000</td>
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

<?php $this->view('includes/modals/event/sponsor')  ?>
<?php $this->view('includes/modals/event/package')  ?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>