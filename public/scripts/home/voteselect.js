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

        vote_user.innerHTML += `
        <div class="container d-flex row">
                <span>Nome: ${data.user.name}</span>
        </div>
        <div class="container d-flex row">
                <span>CPF: ${data.user.cpf}</span>
        </div>
        `;

    }
}

/**
 * 
 * @param {MouseEvent} e 
 */
function voteClick(e) {
    e.preventDefault();

    vote_status.style.animation = "expand-fadein 0.3s forwards";
    document.body.style.overflow = "hidden";

    socket.send(JSON.stringify({
        type: "vote"
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

        if (data.status) {
            vote_status.style.animation = "hidden-fadeout 0.3s forwards";

            vote_user.innerHTML += `
            <div class="container d-flex row">
                    <span>Nome: ${data.name}</span>
            </div>
            <div class="container d-flex row">
                    <span>CPF: ${data.cpf}</span>
            </div>
            `;
        }
    })
}