<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/event.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/side-bar.css">
</head>

<?php $this->view('includes/header') ?>

<div id="event" class="container container-sections side-padding">

    <section class="center-section">
        <img loading="lazy" src="https://picsum.photos/1020/315" alt="Event Cover" class="club-event-image">

        <div class="content">
            <div class="title-wrap">
                <span class="title f-24">Event Name</span>

                <button onclick="registerToEvent(event)" class="button contained">Register Now</button>
            </div>

            <div class="details-wrap">
                <div class="detail-wrap">
                    <div class="icon">
                        <span class="material-icons-outlined">
                            calendar_month
                        </span>
                    </div>
                    <div class="texts">
                        <span>24th August</span>
                        <span>11.00 A.M</span>
                    </div>
                </div>
                <div class="detail-wrap">
                    <div class="icon">
                        <span class="material-icons-outlined">
                            fmd_good
                        </span>
                    </div>
                    <div class="texts">
                        <span>UCSC Grounds</span>
                    </div>
                </div>
            </div>

            <p class="description">
                Explore the World of APIs with Postman! Join us in the API 101 session brought to you by the IEEE Student Branch of UCSC. The session will be hosted by Suraif Muhammad, a Postman Student Expert and a 3rd-year undergraduate at UCSC. Delve into

                Pharetra pharetra massa massa ultricies mi quis hendrerit. Odio ut sem nulla pharetra diam sit amet. Magnis dis parturient montes nascetur ridiculus. Ac turpis egestas integer eget aliquet nibh praesent tristique. Quis vel eros donec ac odio tempor orci.

                Pharetra pharetra massa massa ultricies mi quis hendrerit. Odio ut sem nulla pharetra diam sit amet. Magnis dis parturient montes nascetur ridiculus. Ac turpis egestas integer eget aliquet nibh praesent tristique. Quis vel eros donec ac odio tempor orci.

                Pharetra pharetra massa massa ultricies mi quis hendrerit. Odio ut sem nulla pharetra diam sit amet. Magnis dis parturient montes nascetur ridiculus. Ac turpis egestas integer eget aliquet nibh praesent tristique. Quis vel eros donec ac odio tempor orci.

                Pharetra pharetra massa massa ultricies mi quis hendrerit. Odio ut sem nulla pharetra diam sit amet. Magnis dis parturient montes nascetur ridiculus. Ac turpis egestas integer eget aliquet nibh praesent tristique. Quis vel eros donec ac odio tempor orci.
            </p>
        </div>
    </section>

    <?php $this->view('includes/side-bars/events/right')  ?>
</div>

<?php $this->view('includes/modals/event/register')?>
<script src="<?= ROOT ?>/assets/js/events/event.js"></script>