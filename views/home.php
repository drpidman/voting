<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main/candidates.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">

    <title>Voting</title>
</head>

<body>
    <!-- NAVBAR COM PATROCINADORES E OUTROS -->
    <?php
    require_once APP_ROOT . "/views/components/navbar.php";
    ?>
    <section class="vote-status" id="vote-status">
        <h1>Seu voto foi cumputado!</h1>
    </section>
    <!-- CONTEÚDO BASE -->
    <main class="container d-flex justify-center">
        <!-- CONTEUDO DINAMICO -->
        <section class="candidates pt-3">
            <?php
            foreach ($products as $product) {
            ?>
                <div class="card">
                    <div class="card top align-center">
                        <section class="candidate-number">
                            <span><?php echo $product->product_number ?></span>
                        </section>
                        <img src="<?php echo $product->product_image ?>" alt="canditate">
                    </div>
                    <div class="card body pt-1">
                        <h1><?php echo $product->product_name ?></h1>
                        <br>
                        <p><?php echo $product->product_description ?></p>
                    </div>
                    <div class="card footer w-100 pt-1" data-effect="show-vote-sucess">
                        <button class="btn-success w-100 :effect" action="voteClick" for="<?php echo $product->product_number?>" >VOTAR</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </section>
    </main>
    <footer class="d-flex justify-end">
        <!-- CONTEUDO DINAMICO -->
        <section class="container d-flex col m-1">
            <div class="container d-flex row">
                <span>Votar: 123</span>
            </div>
            <div class="container d-flex row">
                <span>CPF: 454.703.298-01</span>
            </div>
        </section>
    </footer>

    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/home/voteselect.js"></script>
</body>

</html>