<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/auth/login.css">

    <title>Auth</title>
</head>

<body>
    <?php
    require_once APP_ROOT . "/views/components/navbar.php";
    ?>

    <main class="login">
        <section class="login-form">
            <h1>Login - Painel de controle</h1>
            <form method="POST" action="auth">
                <label>
                    <input name="username" type="text" placeholder="username">
                </label>
                <label>
                    <input name="password" type="password" placeholder="******">
                </label>
                <button class="btn-success :effect" type="submit">LOGIN</button>
                <?php
                if (isset($error)) {
                    echo "<span class='pt-1' style='color: red'>" . $error . "</span>";
                }
                ?>
            </form>
        </section>
    </main>
</body>

</html>