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