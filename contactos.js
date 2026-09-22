document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const feedback = document.getElementById('contactFeedback');
    const submitBtn = document.getElementById('contactSubmitBtn');

    if (!form) return;

    function showFeedback(message, type) {
        feedback.textContent = message;
        feedback.className = 'alert alert-' + type;
        feedback.classList.remove('d-none');
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        const mensagem = document.getElementById('mensagem').value.trim();

        // Validação simples do lado do cliente
        if (!nome || !email || !mensagem) {
            showFeedback('Por favor, preenche todos os campos.', 'danger');
            return;
        }

        if (!isValidEmail(email)) {
            showFeedback('Por favor, insere um email válido.', 'danger');
            return;
        }

        // Estado "a enviar"
        submitBtn.disabled = true;
        submitBtn.textContent = 'A enviar...';
        feedback.classList.add('d-none');

        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('email', email);
        formData.append('mensagem', mensagem);

        fetch('contactos.php', {
            method: 'POST',
            body: formData
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                showFeedback(data.message || 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.', 'success');
                form.reset();
            } else {
                showFeedback(data.message || 'Ocorreu um erro ao enviar a mensagem. Tenta novamente.', 'danger');
            }
        })
        .catch(function () {
            showFeedback('Não foi possível enviar a mensagem. Verifica a tua ligação e tenta novamente.', 'danger');
        })
        .finally(function () {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Mensagem';
        });
    });
});