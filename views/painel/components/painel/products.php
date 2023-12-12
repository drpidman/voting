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

            <p class="pt-2">VOTOS ATUALMENTE: <?php echo $product["votes"] ?></p>
            <div class="mt-2 pt-1 progress-bar-vote" style="--vote-percentage: <?php echo $product["percentage"] ?>%">
            </div>

        </section>
    </div>
<?php
}
?>