let socket = new WebSocket(host);

socket.onerror = function(err) {
    console.log("Error", err);
}

socket.onmessage = function(e) {
    const data = JSON.parse(e.data);

    console.log(data);
}



let inputs = {
    /** @type {HTMLInputElement} */
    first_name: document.querySelector("input[name='first_name']"),
    /** @type {HTMLInputElement} */
    second_name: document.querySelector("input[name='second_name']"),
    /** @type {HTMLInputElement} */
    cpf: document.querySelector("input[name='cpf']")
}

let allowVoteButton = document.getElementById("allow-vote");
let vote_status = document.getElementById("vote-status");

/**
 * https://github.com/tiagoporto/gerador-validador-cpf/blob/main/src/lib/calcChecker.ts
 */
function calcFirstChecker(firstNineDigits) {
    let sum = 0

    for (let i = 0; i < 9; ++i) {
        sum += Number(firstNineDigits.charAt(i)) * (10 - i)
    }

    const lastSumChecker = sum % 11
    return lastSumChecker < 2 ? 0 : 11 - lastSumChecker
}

/**
 * https://github.com/tiagoporto/gerador-validador-cpf/blob/main/src/lib/calcChecker.ts
 */
function calcSecondChecker(cpfWithChecker1) {
    let sum = 0

    for (let i = 0; i < 10; ++i) {
        sum += Number(cpfWithChecker1.charAt(i)) * (11 - i)
    }

    const lastSumChecker2 = sum % 11
    return lastSumChecker2 < 2 ? 0 : 11 - lastSumChecker2
}

/**
 * @param {HTMLInputElement} e 
 */
function formatCpf(e) {
    let cpf = e.value.replace(/\D/g, '');
    let formattedCpf = '';

    for (let i = 0; i < cpf.length; i++) {
        formattedCpf += cpf[i];

        if (i === 2 || i === 5) {
            formattedCpf += '.';
        } else if (i === 8) {
            formattedCpf += '-';
        }
    }

    e.value = formattedCpf;
}

/**
 * 
 * @param {string} cpf 
 * @returns {boolean}
 */
function validateCpf(cpf) {
    // https://github.com/tiagoporto/gerador-validador-cpf/blob/main/src/lib/CPF.ts
    const cleanCpf = String(cpf).replace(/[\s.-]/g, '');
    const firstNineDigits = cleanCpf.slice(0, 9);
    const checker = cleanCpf.slice(9, 11);

    if (cleanCpf.length > 11 || cleanCpf.length < 11) {
        return false;
    }

    for (let i = 0; i < 10; i++) {
        if (cleanCpf === Array.from({ length: cleanCpf.length + 1 }).join(String(i))) {
            return false;
        }
    }

    const checker1 = calcFirstChecker(firstNineDigits)
    const checker2 = calcSecondChecker(`${firstNineDigits}${checker1}`)

    return checker === `${checker1}${checker2}`
}