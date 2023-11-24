<?php
foreach ($products as $product) {
?>
    <div class="card" product="<?php echo $product["product_name"] ?>">
        <section class="card top align-center">
            <section class="card hover:actions">
                <button class="btn-warn :effect" for="<?php echo $product["product_name"] ?>" onclick="deleteProduct(this)">Deletar</button>
            </section>
            <section class="candidate-number">
                <span><?php echo $product["product_number"] ?></span>
            </section>
            <img src="<?php echo $product["product_image"] ?>" alt="canditate">
        </section>
        <section class="card body pt-1">
            <h1><?php echo $product["product_name"] ?></h1>
            <br>
            <p><?php echo $product["product_description"] ?></p>
        </section>
    </div>
<?php
}
?>