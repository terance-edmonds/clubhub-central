<head>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/login.css">
</head>

<div id="login" class="full-container">
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
            <div class="input-wrap">
                <label for="email">Email Address</label>
                <input id="email" type="email" placeholder="Email Address" required>
            </div>
            <div class="input-wrap">
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="Password" required>
            </div>
            <a href="/forgot-password" class="cl-theme f-14">Forgot Password?</a>

            <button class="button contained">Login</button>

            <div class="bottom-text">
                Don't have an account? <a href="<?= ROOT ?>/register" class="cl-theme">Register here</a>
            </div>
        </form>
    </section>
</div>