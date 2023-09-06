<?php
session_start()
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/components/common/all.css">
    <link rel="stylesheet" href="../css/components/auth/login.css">

    <title>Auth</title>
</head>

<body>
    <nav class="navbar">
        <section class="nav-item">
            <h1>ESantos Soluções</h1>
        </section>
        <section class="nav-item">

        </section>
        <section class="nav-item">

        </section>
    </nav>

    <main class="login">
        <section class="login-form">
            <h1>Login - Painel de controle</h1>
            <form method="POST" action="../actions/login.php">
                <label>
                    <input name="username" type="text" placeholder="username">
                </label>
                <label>
                    <input name="password" type="password" placeholder="******">
                </label>
                <button class="btn-success :effect" type="submit">LOGIN</button>
            </form>
        </section>
    </main>
</body>
</html>