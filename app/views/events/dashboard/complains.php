<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event-dashboard.css">
</head>

<?php $this->view('includes/header') ?>

<!-- alerts -->
<?php $this->view('includes/alerts') ?>

<div id="event-dashboard-registrations" class="container container-sections side-padding event-dashboard dashboard-container">
    <?php $this->view('includes/side-bars/events/dashboard/left', ["menu" => $menu])  ?>

    <section class="center-section">
        <div class="title-bar">
            <div class="title-wrap">
                <span class="title">Complains</span>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Complain</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="table-data">
                        <td>User Name</td>
                        <td>sample@mailinator.com</td>
                        <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Labore nulla obcaecati explicabo et perspiciatis quos consectetur impedit eum dolore. Assumenda libero explicabo necessitatibus magni amet minus eum suscipit adipisci aliquid.</td>
                        <td align="center">
                            <button class="icon-button cl-red">
                                <span class="material-icons-outlined">
                                    delete
                                </span>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>

<script src="<?= ROOT ?>/assets/js/events/event.js"></script>