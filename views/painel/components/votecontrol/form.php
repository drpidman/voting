<section class="product-form">
    <!-- FORMULARIO -->
    <h1>Formulario para liberação de cabine</h1>
    <p class="mt-1">Essas informações serão usadas para permitir que 
        votos sejam computados
    </p>
    <form class="mt-2" method="POST">
        <!-- METADADOS -->
        <section class="d-flex form-item md-col md-w100">
            <label class="mt-1 w-100">
                Nome:
                <input class="mt-1 w-100" name="first_name" type="text" placeholder="Nome" required>
            </label>
            <label class="mt-1 w-100">
                Sobrenome:
                <input class="mt-1" name="second_name" type="text" placeholder="Sobrenome" required>
            </label>
        </section>
        <section class="d-flex form-item md-col pt-1 w-100 mt-2">
            <label class="w-100">
                CPF:
                <input class="w-100 mt-1" name="cpf" type="telephone" placeholder="000.000.000-00" required oninput="formatCpf(this)">
            </label>
        </section>
        <!-- ACTION - CONFIRMAR -->
        <section class="d-flex form-item pt-1 w-100">
            <button class="w-100 btn-success :effect" type="button" id="allow-vote" onclick="allowVote(this)">Liberar cabine</button>
        </section>
    </form>
</section>