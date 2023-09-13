let inputs = {
    product_name: document.querySelector("input[name='product_name']"),
    product_description: document.querySelector("input[name='product_description']"),
    product_number: document.querySelector("input[name='product_number']"),
    product_image: document.querySelector("input[name='product_image']")
}

let candidate = {
    name: document.getElementById("candidate-name"),
    description: document.getElementById("candidate-description"),
    number: document.getElementById("candidate-number"),
    image: document.getElementById("candidate-image")
}

let imageFile = {};

function productTextValueChange(e) {
    e.preventDefault()
    switch (this.name) {
        case "product_name":
            candidate.name.innerText = this.value;
            break;
        case "product_description":
            candidate.description.innerText = this.value;
            break;
        case "product_number":
            candidate.number.innerText = this.value.toString();
            break;
        case "product_image":
            imageFile = this.files[0];
            let reader = new FileReader();

            reader.onloadend = function () {
                console.log(reader)
                candidate.image.setAttribute("src", reader.result);
            }

            if (imageFile) {
                reader.readAsDataURL(imageFile)
            } else {
                candidate.image.setAttribute("src", "");
            }
    }
}

async function postProduct(ev) {
    ev.preventDefault();

    console.log(this)

    let product_metadata = new FormData();
    product_metadata.append("product_name", inputs.product_name.value);
    product_metadata.append("product_description", inputs.product_description.value);
    product_metadata.append("product_number", parseInt(inputs.product_number.value));
    product_metadata.append("product_image", candidate.image.getAttribute("src"));

    this.innerText = "aguarde..."

    await fetch(action_endpoint, {
        method: "POST",
        body: product_metadata
    }).then((res) => {
        if (res.status == 404) {
            this.innerText = "Dados incompletos";

            setTimeout(() => { 
                this.innerText = "confirmar"
            }, 3000)
            return;
        }

        this.innerText = "Sucesso";

        setTimeout(() => { 
            this.innerText = "confirmar"
        }, 2000)
    })
}

document.getElementById("post-product").addEventListener('click', postProduct);

inputs.product_name.addEventListener('input', productTextValueChange);
inputs.product_description.addEventListener('input', productTextValueChange);
inputs.product_number.addEventListener('input', productTextValueChange);
inputs.product_image.addEventListener('change', productTextValueChange);