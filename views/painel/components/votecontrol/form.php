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
                <input class="w-100" name="cpf" type="telephone" placeholder="000.000.000-00" required oninput="formatCpf(this)">
            </label>
        </section>
        <!-- ACTION - CONFIRMAR -->
        <section class="d-flex form-item pt-1 w-100">
            <button class="w-100 btn-success :effect" type="button" id="allow-vote">Liberar cabine</button>
        </section>
    </form>

    <script src="<?php echo URL_SUBFOLDER ?>/public/scripts/votecontrol/cpfvalidator.js"></script>
</section>