<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/painel/productmgr/container.css">

    <title>Controle de Cabine</title>
</head>

<body>
    <?php
    require_once APP_ROOT . '/views/components/navbar.php'
    ?>

    <main class="d-flex col justify-center align-center pt-3">
        <section class="d-flex row w-100 align-center justify-center">
            <section class="product-form">
                <!-- FORMULARIO -->
                <form method="POST">
                    <!-- METADADOS -->
                    <section class="d-flex form-item md-col md-w100">
                        <label>
                            Nome:
                            <input name="first_name" type="text" placeholder="Nome" required>
                        </label>
                        <label>
                            Sobrenome
                            <input name="second_name" type="text" placeholder="Sobrenome" required>
                        </label>
                    </section>
                    <section class="d-flex form-item md-col pt-1 w-100">
                        <label class="w-100">
                            CPF:
                            <input class="w-100" name="cpf" type="telephone" placeholder="000.000.000-00" required>
                        </label>
                    </section>
                    <!-- ACTION - CONFIRMAR -->
                    <section class="d-flex form-item pt-1 w-100">
                        <button class="w-100 btn-success :effect" type="button" id="allow-vote">Liberar cabine</button>
                    </section>
                </form>
            </section>
        </section>
    </main>
</body>

</html>