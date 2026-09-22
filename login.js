function login() {
    const email = document.getElementById('email').value.trim();
    const pass  = document.getElementById('pass').value;

    if (!email || !pass) {
        Swal.fire('Atenção', 'Preenche o email e a palavra-passe.', 'warning');
        return;
    }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('pass', pass);

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Bem-vindo!',
                text: data.message,
                icon: 'success',
                timer: 1200,
                showConfirmButton: false
            }).then(() => {
                // Tanto admin como cliente voltam para a home (index.php).
                // É o index.php que decide o que mostrar consoante o "role" da sessão.
                window.location.href = data.redirect || 'index.php';
            });
        } else {
            Swal.fire('Erro', data.message, 'error');
        }
    })
    .catch(() => {
        Swal.fire('Erro', 'Não foi possível ligar ao servidor. Tenta novamente.', 'error');
    });
}
