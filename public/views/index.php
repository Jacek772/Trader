<?php
    session_start();
    if($_SESSION["logged"])
    {
        header('Location: /home');
        die();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/zero.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/index.css">
    <title>Trader - Login</title>
</head>
<body>
    <div class="container container-row">
        <main class="bg-gray">
            <img src="/public/img/logo_1.png" alt="logo_1" class="img-logo">
        </main>
        <section class="bg-shadow-left bg-lightgray">
            <div class="img-mobile-logo-container">
                <img src="/public/img/logo_1.png" alt="logo_1" class="img-mobile-logo">
            </div>

            <div class="form-login-container w-75">
                <h2 class="form-title color-white">Login</h2>
                <hr class="w-100"/>
                <form class="w-100" method="POST" action="api/auth/login">
                    <div class="form-item">
                        <input name="login" type="text" placeholder="login" class="input-text">
                    </div>
                    <div class="form-item">
                        <input name="password" type="text" placeholder="password" class="input-text">
                    </div>
                    <div class="form-item form-item-left">
                        <input type="checkbox" class="input-checkbox">
                        <label class="input-label color-white">Remember</label>
                    </div>
                        <?php
                            if(isset($messages))
                            {
                            ?>
                                <div class="alert alert-danger">
                                    <h2 class="alert-title">Błąd logowania</h2>
                                    <p class="alert-text">
                                        <?php
                                        foreach ($messages as $message)
                                        {
                                            echo $message;
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php
                            }
                        ?>
                    <div class="form-item">
                        <button class="button button-primary w-50" type="submit">Login</button>
                    </div>

                </form>
            </div>
        </section>
    </div>
</body>
</html>