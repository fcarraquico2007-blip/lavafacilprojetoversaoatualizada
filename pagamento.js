// assets/js/pagamento.js
// Igual ao original, mas agora confirma o pagamento na base de dados
// (via confirmar_pagamento.php) antes de seguir para a página de sucesso.
// ID_PEDIDO vem do <script> inline em metodosdepagamento.php.

function mostrarMBWay() {
    document.getElementById("formMBWay").classList.remove("oculto");
    document.getElementById("formCartao").classList.add("oculto");
}

function mostrarCartao() {
    document.getElementById("formCartao").classList.remove("oculto");
    document.getElementById("formMBWay").classList.add("oculto");
}

async function confirmarPagamentoNaBaseDeDados() {
    const resposta = await fetch("confirmar_pagamento.php?id=" + ID_PEDIDO, {
        method: "POST"
    });
    const json = await resposta.json();
    if (!json.sucesso) {
        throw new Error(json.erro || "Não foi possível confirmar o pagamento.");
    }
}

function pagarMBWay() {
    const numero = document.getElementById("mbwayNumero").value;
    const status = document.getElementById("mbwayStatus");

    if (numero.length !== 9) {
        status.style.color = "red";
        status.innerText = "Número inválido.";
        return;
    }

    status.style.color = "#2980b9";
    status.innerText = "A enviar pedido MBWay...";

    setTimeout(async () => {
        try {
            await confirmarPagamentoNaBaseDeDados();
            status.style.color = "#27ae60";
            status.innerText = "Pagamento MBWay concluído!";
            setTimeout(() => {
                window.location.href = "sucessopagamento.html";
            }, 1500);
        } catch (erro) {
            status.style.color = "red";
            status.innerText = erro.message;
        }
    }, 2000);
}

function pagarCartao() {
    const numero = document.getElementById("cartaoNumero").value;
    const validade = document.getElementById("cartaoValidade").value;
    const cvv = document.getElementById("cartaoCVV").value;
    const status = document.getElementById("cartaoStatus");

    if (numero.length < 16 || cvv.length !== 3 || validade.length < 4) {
        status.style.color = "red";
        status.innerText = "Dados do cartão inválidos.";
        return;
    }

    status.style.color = "#2980b9";
    status.innerText = "A processar pagamento...";

    setTimeout(async () => {
        try {
            await confirmarPagamentoNaBaseDeDados();
            status.style.color = "#27ae60";
            status.innerText = "Pagamento com cartão concluído!";
            setTimeout(() => {
                window.location.href = "sucessopagamento.html";
            }, 1500);
        } catch (erro) {
            status.style.color = "red";
            status.innerText = erro.message;
        }
    }, 2000);
}
