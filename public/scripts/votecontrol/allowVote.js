/**
 * @param {MouseEvent} e 
 */
async function allowVote(e) {

    if (inputs.first_name.value == "" || inputs.second_name == "" || inputs.cpf == "") {
        allowVoteButton.innerText = "Complete todos os campos"
        allowVoteButton.style.backgroundColor = "#EF6F6C";

        setTimeout(() => {
            allowVoteButton.innerText = "Liberar cabine"
            allowVoteButton.style.backgroundColor = "";
        }, 3000)
        return;
    }

    if (!validateCpf(inputs.cpf.value)) {
        allowVoteButton.innerText = "CPF Invalido"
        allowVoteButton.style.backgroundColor = "#EF6F6C";

        setTimeout(() => {
            allowVoteButton.innerText = "Liberar cabine"
            allowVoteButton.style.backgroundColor = "";
        }, 3000)

        return;
    }

    let allowForm = new FormData();
    allowForm.append("user_name", inputs.first_name.value)
    allowForm.append("user_surname", inputs.second_name.value)
    allowForm.append("user_cpf", inputs.cpf.value);

    let statusForm = new FormData();
    statusForm.append("id", 12);
    statusForm.append("vote_status", true);
    statusForm.append("user_name", allowForm.get("user_name"));
    statusForm.append("user_surname", allowForm.get("user_surname"));
    statusForm.append("user_cpf", allowForm.get("user_cpf"));

    await fetch(action_allow_endpoint, {
        method: "POST",
        body: allowForm
    }).then(async (res) => {
        if (res.status === 401) {
            const data = await res.json();

            vote_status.style.animation = "expand-fadein 0.3s forwards";
            vote_status.style.backgroundColor = "#EF6F6C";
            document.body.style.overflow = "hidden";

            vote_status.innerHTML = `
                    <h1>Ocorreu um erro</h1>
                    <p>Motivo: ${data.message}</p>
                `

            setTimeout(() => {
                vote_status.style.animation = "hidden-fadeout  0.3s forwards";
                vote_status.style.backgroundColor = "";
                document.body.style.overflow = "";
                vote_status.innerHTML = "";
            }, 4000)
        }

        if (res.ok) {
            const data = await res.json();
            vote_status.style.animation = "expand-fadein 0.3s forwards";
            document.body.style.overflow = "hidden";

            vote_status.innerHTML += `
                    <h1 style="font-size: 2rem">Agurdando voto</h1>
                    <p>Usuario: ${data.name}</p>
                    <p>CPF: ${data.cpf}</p>
                `

            socket.send(JSON.stringify({
                type: "allow-vote",
                user: {
                    name: data.name,
                    cpf: data.cpf
                }
            }));
            
            await fetch(updateVoteStatus, {
                method: "POST",
                body: statusForm
            }).then(async (res) => {
                console.log(await res.text());
            })

        }
    })


} 