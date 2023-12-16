<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/painel/productmgr/container.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main/candidates.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main.css">


    <script>
        let action_allow_endpoint = "<?php echo $allowvote ?>";
        let onVoteItem = "<?php echo $routes->get('painel-vote-control-vote')->getPath(); ?>";
        let userGet = "<?php echo $routes->get('painel-user-get')->getPath(); ?>";

        let voteStatus = "<?php echo $routes->get('painel-status-get')->getPath(); ?>";
        let updateVoteStatus = "<?php echo $routes->get('painel-status-update')->getPath(); ?>";
        let updateVoteStatusErase = "<?php echo $statusUpdateErase ?>";


        let host = "ws://<?php echo $_SERVER['SERVER_ADDR'] ?>:8090";
    </script>
    <title>Controle de Cabine</title>
</head>

<body>
    <?php
    require_once APP_ROOT . '/views/components/navbar.php'
    ?>

    <section class="vote-status col" id="vote-status">
    </section>

    <main class="d-flex col justify-center align-center pt-3">
        <section class="d-flex col w-100 md-w100 md-col justify-center align-center">
            <div class="d-flex col w-30 justify-center align-start">
                <h1>Ferramentas preventivas contra falhas</h1>
                <p class="mt-1">Limpar cabine: Limpar o status de voto ou remover o usuário que abriu um voto</p>
                <p class="mt-1">Recarregar cabine: Se caso a página da cabine travar, recarregue a mesma com esta função</p>
            </div>
            <div class="d-flex row justify-center mt-1">
                <a class="m-1" href="<?php echo $votecontrollerPage ?>">
                    <button class="small-btn bd-green">Página anterior</button>
                </a>

                <a class="m-1">
                    <button onclick="votingStatusClean(event)" class="small-btn bd-green">Limpar cabine</button>
                </a>
                <a class="m-1">
                    <button onclick="votingReloadPage(event)" class="small-btn bd-green">Recarregar cabine</button>
                </a>
            </div>
        </section>

        <section class="d-flex row w-100 align-center justify-center pt-1 mt-2">
            <?php
            require_once "components/votecontrol/form.php"
            ?>
        </section>
    </main>

    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/votecontrol/index.js"></script>
    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/votecontrol/allowVote.js"></script>
</body>

</html>