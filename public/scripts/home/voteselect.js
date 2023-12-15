let socket = new WebSocket(host);

let vote_click = document.querySelectorAll("button[action='voteClick']")
let vote_status = document.getElementById("vote-status");
let vote_user = document.getElementById("vote-user");

socket.onerror = function (err) {
    console.log(err);
}

socket.onmessage = function (e) {
    const data = JSON.parse(e.data);

    if (data.type == "allow-vote") {
        vote_status.style.animation = "hidden-fadeout  0.3s forwards";
        document.body.style.overflow = "";

        console.log(data);

        vote_user.innerHTML = `
        <div class="container d-flex row">
                <span>Nome: ${data.user.name}</span>
        </div>
        <div class="container d-flex row">
                <span id="user-query-cpf">N. Telefone: ${data.user.cpf}</span>
        </div>
        `;

        // window.location.reload();
    }
}

/**
 * 
 * @param {MouseEvent} e 
 */
async function voteClick(e) {
    e.preventDefault();

    const selectedItem = e.target.attributes.for.nodeValue;

    let form = new FormData();
    form.append("id", 12)

    fetch(voteStatus, {
        method: "POST",
        body: form
    }).then(async (res) => {
        const data = await res.json()

        if (data != null && data.status) {
            vote_status.innerHTML = `
            <h1 style="font-size: 2rem;">Aguarde!</h1>
            <p>Por favor, aguarde, vamos verificar se você possui mais votos disponiveis</p>`

            vote_status.style.animation = "expand-fadein 0.3s forwards";
            document.body.style.overflow = "hidden";

            vote_user.innerHTML = `
            <div class="container d-flex row">
                    <span>Nome: ${data.status_username}</span>
            </div>
            <div class="container d-flex row">
                    <span>N. Telefone:: ${data.status_usercpf}</span>
            </div>
            `;

            setTimeout(async () => {
                window.location.reload();
            }, 3000)
        }

    })

    /**
     * Pegar o nome de usuario do elemento filho do container vote_user.
     * Transformar "Nome: nome" em: ["Nome:", "nome"] e pegar o item 1 do array("nome").
     * Começar a string apartir do indice 1, removendo o espaço em branco que é indice 0
     * @type {String}
     */
    let username = vote_user.children[0].innerText.split(":")[1].slice(1);
    /**
     * @type {String}
    */
    let cpf = vote_user.children[1].innerText.split(":")[1].slice(1);

    await socket.send(JSON.stringify({
        type: "vote",
        selectedItem,
        user: { username, cpf }
    }))
}

for (let button of vote_click) {
    button.addEventListener("click", voteClick);
}

window.onload = function () {
    let form = new FormData();
    form.append("id", 12)

    fetch(voteStatus, {
        method: "POST",
        body: form
    }).then(async (res) => {
        const data = await res.json();
        console.log(data);

        if (data != null && data.status) {
            vote_status.style.animation = "hidden-fadeout 0.3s forwards";

            vote_user.innerHTML = `
                <div class="container d-flex row">
                        <span>Nome: ${data.status_username}</span>
                </div>
                <div class="container d-flex row">
                        <span>N. Telefone: ${data.status_usercpf}</span>
                </div>
                `;
        }

    })
}