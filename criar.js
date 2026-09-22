function criarconta() {
    const nome  = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const pass  = document.getElementById('pass').value;
    const cpass = document.getElementById('cpass').value;
    const check = document.getElementById('check').checked;

    // Validação simples no cliente (o servidor valida sempre outra vez)
    if (!nome || !email || !pass || !cpass) {
        Swal.fire('Atenção', 'Preenche todos os campos.', 'warning');
        return;
    }

    if (pass.length < 6) {
        Swal.fire('Atenção', 'A palavra-passe deve ter pelo menos 6 caracteres.', 'warning');
        return;
    }

    if (pass !== cpass) {
        Swal.fire('Atenção', 'As palavras-passe não coincidem.', 'warning');
        return;
    }

    if (!check) {
        Swal.fire('Atenção', 'Tens de aceitar os termos para continuar.', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('email', email);
    formData.append('pass', pass);
    formData.append('cpass', cpass);

    fetch('registar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Conta criada!',
                text: data.message,
                icon: 'success'
            }).then(() => {
                window.location.href = 'login.html';
            });
        } else {
            Swal.fire('Erro', data.message, 'error');
        }
    })
    .catch(() => {
        Swal.fire('Erro', 'Não foi possível ligar ao servidor. Tenta novamente.', 'error');
    });
}
