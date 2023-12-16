let product_list = document.getElementById("product-list");

/**
 * 
 * @param {MouseEvent} e 
 */
async function deleteProduct(e) {
    let product = e.attributes.for.nodeValue;

    let data = new FormData();
    data.append("product_name", product);

    await fetch(action_delete_endpoint, {
        method: "POST",
        body: data
    }).then(async (res) => {
        const data = await res.json();

        document.querySelectorAll("div[class='card']").forEach((card) => {
            if (data.deleted.product_name == card.attributes['product'].nodeValue) {
                card.remove()
            }
        });
    })
}