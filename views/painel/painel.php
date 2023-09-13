<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/painel/productmgr/container.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main/candidates.css">

    <title>Painel</title>

    <script>
        let action_endpoint = "<?php echo $addproduct ?>";
    </script>
</head>

<body>
    <?php
    require_once APP_ROOT . "/views/components/navbar.php";
    ?>

    <main class="d-flex col justify-center align-center pt-3">
        <div class="product d-flex row w-50">
            <!-- ADICIONAR PRODUTO -->
            <?php
            require_once "components/form.php"
            ?>
            <!-- PREVISUALIZAR PRODUTO -->
            <?php
            require_once "components/preview.php"
            ?>
        </div>
        <div class="products pt-3">
            3...
        </div>
    </main>

    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/painel/postproduct.js"></script>
</body>

</html>