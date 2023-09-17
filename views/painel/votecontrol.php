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
            <?php
                require_once "components/votecontrol/form.php" 
            ?>
        </section>
    </main>
</body>

</html>