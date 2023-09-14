<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/register.css">
</head>

<div id="register" class="full-container">
    <section class="section left">
        <div class="content">
            <span class="title">
                The Perfect Event Every Time!
            </span>
            <span class="sub-title">WITH <span class="cl-theme">CLUB CENTRAL</span>
        </div>
    </section>
    <section class="section right">
        <form class="form">
            <div class="multi-wrap">
                <div class="input-wrap">
                    <label for="first_name">Email Address</label>
                    <input id="first_name" type="text" placeholder="First Name" required>
                </div>
                <div class="input-wrap">
                    <label for="last_name">Last Name</label>
                    <input id="last_name" type="text" placeholder="Last Name" required>
                </div>
            </div>
            <div class="input-wrap">
                <label for="email">Email Address</label>
                <input id="email" type="email" placeholder="Email Address" required>
            </div>
            <div class="multi-wrap">
                <div class="input-wrap">
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Password" required>
                </div>
                <div class="input-wrap">
                    <label for="confirm_password">Confirm Password</label>
                    <input id="confirm_password" type="password" placeholder="Confirm Password" required>
                </div>
            </div>

            <button class="button contained">Register</button>

            <div class="bottom-text">
                Already have an account? <a href="<?= ROOT ?>/login" class="cl-theme">Login here</a>
            </div>
        </form>
    </section>
</div>