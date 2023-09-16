<section class="product-form w-100 m-1">
    <!-- FORMULARIO -->
    <form method="POST">
        <!-- METADADOS -->
        <section class="d-flex form-item md-col md-w100">
            <label>
                Nome do produto
                <input name="product_name" type="text" placeholder="Banana da terra" required>
            </label>
            <label>
                Descrição
                <input name="product_description" type="text" placeholder="A banana da terra..." required>
            </label>
        </section>
        <!-- META - NUMERAÇÃO -->
        <section class="d-flex form-item pt-1">
            <label class="w-100">
                Numeração
                <input name="product_number" type="number" placeholder="0..1..2" required>
            </label>
        </section>
        <!-- META - UPLOAD -->
        <section class="d-flex form-item pt-1">
            <label class="w-100">
                Imagem
                <input name="product_image" type="file" accept=".jpg, .png, .jpeg" required>
            </label>
        </section>
        <!-- ACTION - CONFIRMAR -->
        <section class="d-flex form-item pt-1 w-100">
            <button class="w-100 btn-success :effect" type="button" id="post-product">confirmar</button>
        </section>
    </form>
    <!-- END FORMULARIO -->
</section>