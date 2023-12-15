let list = document.getElementById("product-list");

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

    await fetch(action_post_endpoint, {
        method: "POST",
        body: product_metadata
    }).then(async (res) => {
        if (res.status == 404) {
            this.innerText = "Dados incompletos";
            this.style.backgroundColor = "#EF6F6C";

            setTimeout(() => {
                this.innerText = "confirmar"
                this.style.backgroundColor = "";
            }, 3000)
            return;
        }

        this.innerText = "Sucesso";

        const product = await res.json();
        console.log(product)

        list.innerHTML += `
        <div class="card" product="${product.product_name}">
            <section class="card top align-center">
                <section class="card hover:actions">
                    <button class="btn-warn :effect" for="${product.product_name}" onclick="deleteProduct(this)">Deletar</button>
                </section>
                <section class="candidate-number">
                    <span>${product.product_number}</span>
                </section>
                <img src="${product.product_image}" alt="canditate">
            </section>
            <section class="card body pt-1">
                <h1>${product.product_name}</h1>
                <br>
                <p>${product.product_description}</p>
            </section>
        </div>
        `

        setTimeout(() => {
            this.innerText = "confirmar"
        }, 2000)
    })
}


async function generateProductRelatory() {
    const printableWindow = window.open();

    await fetch(action_getall_endpoit)
    .then(async (res) => {
        const products = await res.json();

        products.map((product) => {
            printableWindow.document.write(`
            <head>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                    body {
                        font-family: 'Josefin Sans', sans-serif !important;
                    }
                </style>
            </head>
            <div style="padding: .5rem 1.5rem; border: 0.5px solid darkgray; margin: 0.5rem; border-radius: 0.5rem;">
                <h3>Nome do produto: ${product.product_name}</h3>
                <p>Numero do produto: ${product.product_number}</p>
                <p>Descrição do produto: ${product.product_description}</p>
                <p>N. de votos: ${product.votes}</p>
            </div>
            `)
        })

        printableWindow.print()
        printableWindow.close()
    })
}


async function generateVotesRelatory() {
    const printableWindow = window.open();

    await fetch(action_getall_voteshistory)
    .then(async (res) => {
        const votesHistories = await res.json();

        votesHistories.map((history) => {
            printableWindow.document.write(`
            <head>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');
                    body {
                        font-family: 'Josefin Sans', sans-serif !important;
                    }
                </style>
            </head>
            <div style="padding: .5rem 1.5rem; border: 0.5px solid darkgray; margin: 0.5rem; border-radius: 0.5rem;">
                <h3>Nome do produto votado: ${history.product_name}</h3>
                <p>Usuario: ${history.user_name}</p>
                <p>Votou em: ${history.votedAt}</p>
            </div>
            `)
        })

        printableWindow.print()
        printableWindow.close()

        console.log(votesHistories)
    })
}

document.getElementById("post-product").addEventListener('click', postProduct);
inputs.product_name.addEventListener('input', productTextValueChange);
inputs.product_description.addEventListener('input', productTextValueChange);
inputs.product_number.addEventListener('input', productTextValueChange);
inputs.product_image.addEventListener('change', productTextValueChange);