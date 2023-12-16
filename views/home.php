<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main/candidates.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/painel/productmgr/container.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/main/footer.css">

    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/navbar.css">
    <link rel="stylesheet" href="<?php echo URL_SUBFOLDER ?>/public/components/common/all.css">

    <script>
        let host = "ws://<?php echo $_SERVER['SERVER_ADDR'] ?>:8090";
        let voteStatus = "<?php echo $routes->get('painel-status-get')->getPath(); ?>";

        let products = <?php echo json_encode($products) ?>;
    </script>

    <style>
        /* Estilos para o teclado numérico */
        .numeric-keyboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
        }

        .numeric-keyboard button {
            padding: 15px;
            font-size: 18px;
            background-color: #fff;
            cursor: pointer;
        }

        /* Estilos para a input */
        
    </style>

    <title>Voting</title>
</head>

<body>
    <!-- NAVBAR COM PATROCINADORES E OUTROS -->
    <?php
    require_once APP_ROOT . "/views/components/navbar.php";
    ?>
    <section class="vote-status" id="vote-status" style="z-index: 100; opacity: 1">
        <h1 style="font-size: 2rem;">Aguardando liberação</h1>
        <p>Aguardando a cabine</p>
    </section>
    <!-- CONTEÚDO BASE -->
    <main class="container d-flex col justify-center mb-5">
        <!-- TECLADO -->
        <!-- Input para exibir o número digitado -->
        <!-- Teclado numérico -->
        <div class="product-form">
            <form>
                <section class="form-item p-2">
                    <label>
                        <input class="mt-2" type="text" id="vote-input" class="vote-input" placeholder="Digite seu voto">
                    </label>
                </section>
            </form>
        </div>

        <div class="numeric-keyboard p-2">
            <button class="btn-white" onclick="appendToInput(1)">1</button>
            <button class="btn-white" onclick="appendToInput(2)">2</button>
            <button class="btn-white" onclick="appendToInput(3)">3</button>
            <button class="btn-white" onclick="appendToInput(4)">4</button>
            <button class="btn-white" onclick="appendToInput(5)">5</button>
            <button class="btn-white" onclick="appendToInput(6)">6</button>
            <button class="btn-white" onclick="appendToInput(7)">7</button>
            <button class="btn-white" onclick="appendToInput(8)">8</button>
            <button class="btn-white" onclick="appendToInput(9)">9</button>
            <button class="btn-white" onclick="appendToInput(0)">0</button>
            <button class="btn-error" onclick="clearInput()">Limpar</button>
            <button class="btn-success" onclick="voteClickNew(event)">Votar</button>
        </div>
    </main>
    </main>
    <footer class="footer-vote-status d-flex justify-end">
        <!-- CONTEUDO DINAMICO -->
        <section class="container d-flex col m-1" id="vote-user"></section>
    </footer>
    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/home/voteselect.js"></script>
</body>

</html>