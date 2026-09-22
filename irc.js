const ids = [
    "vendas", "subsidios", "outrosRendimentos",
    "compras", "fse", "pessoal", "depreciacoes", "juros", "outrosGastos",
    "naoDedutiveis", "outrosAcrescimos",
    "beneficios", "prejuizos", "outrasDeducoes",
    "autonomas", "pagamentos", "retencoes"
];

const numero = id =>
    Number(document.getElementById(id).value) || 0;

const dinheiro = valor =>
    valor.toLocaleString("pt-PT", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }) + " €";

const mostrar = (id, valor) => {
    document.getElementById(id).textContent = dinheiro(valor);
};


function calcular() {

    // 1. RENDIMENTOS
    const rendimentos =
        numero("vendas") +
        numero("subsidios") +
        numero("outrosRendimentos");


    // 2. GASTOS
    const gastos =
        numero("compras") +
        numero("fse") +
        numero("pessoal") +
        numero("depreciacoes") +
        numero("juros") +
        numero("outrosGastos");


    // 3. RESULTADO CONTABILÍSTICO
    const resultado = rendimentos - gastos;


    // 4. AJUSTAMENTOS FISCAIS

    const acrescimos =
        numero("naoDedutiveis") +
        numero("outrosAcrescimos");

    const deducoes =
        numero("beneficios") +
        numero("prejuizos") +
        numero("outrasDeducoes");


    // LUCRO TRIBUTÁVEL
    const lucroTributavel =
        Math.max(0, resultado + acrescimos - deducoes);


    // 5. TAXAS E DERRAMAS

    const irc =
        lucroTributavel *
        numero("taxaIRC") / 100;

    const derramaMunicipal =
        lucroTributavel *
        numero("derramaMunicipal") / 100;

    const derramaEstadual =
        lucroTributavel > 1500000
            ? lucroTributavel *
              numero("derramaEstadual") / 100
            : 0;

    const autonomas = numero("autonomas");


    // TOTAL DO IMPOSTO
    const impostoTotal =
        irc +
        derramaMunicipal +
        derramaEstadual +
        autonomas;


    // 6. PAGAMENTOS
    const pagamentos =
        numero("pagamentos") +
        numero("retencoes");


    // VALOR FINAL
    const valorFinal =
        impostoTotal - pagamentos;


    // -------------------------
    // ATUALIZAR HTML
    // -------------------------

    mostrar("totalRendimentos", rendimentos);
    mostrar("resRendimentos", rendimentos);

    mostrar("totalGastos", gastos);
    mostrar("resGastos", gastos);

    mostrar("resultado", resultado);
    mostrar("topResultado", resultado);

    mostrar("totalAcrescimos", acrescimos);
    mostrar("totalDeducoes", deducoes);

    mostrar("lucroTributavel", lucroTributavel);
    mostrar("topLucro", lucroTributavel);

    mostrar("topIRC", irc);

    mostrar("totalPagamentos", pagamentos);


    // RESUMO
    mostrar("sLucro", lucroTributavel);
    mostrar("sIRC", irc);
    mostrar("sDM", derramaMunicipal);
    mostrar("sDE", derramaEstadual);
    mostrar("sAuto", autonomas);

    mostrar("totalImposto", impostoTotal);

    mostrar("sPagamentos", numero("pagamentos"));
    mostrar("sRetencoes", numero("retencoes"));
    mostrar("sTotalPagamentos", pagamentos);


    // TAXA DE IRC
    document.getElementById("sTaxa").textContent =
        numero("taxaIRC").toFixed(2).replace(".", ",");


    // PAGAR OU RECEBER
    if (valorFinal >= 0) {

        document.getElementById("topEstado").textContent =
            "A PAGAR";

        document.getElementById("finalLabel").textContent =
            "PAGAR";

    } else {

        document.getElementById("topEstado").textContent =
            "A RECEBER";

        document.getElementById("finalLabel").textContent =
            "RECEBER";
    }


    mostrar("topFinal", Math.abs(valorFinal));
    mostrar("finalValue", Math.abs(valorFinal));
}


// -------------------------
// ATUALIZAR AUTOMATICAMENTE
// -------------------------

ids.forEach(id => {

    document
        .getElementById(id)
        .addEventListener("input", calcular);

});


["taxaIRC", "derramaMunicipal", "derramaEstadual"]
.forEach(id => {

    document
        .getElementById(id)
        .addEventListener("change", calcular);

});


// -------------------------
// LIMPAR CAMPOS
// -------------------------

document.getElementById("clearBtn").onclick = () => {

    ids.forEach(id => {
        document.getElementById(id).value = 0;
    });

    calcular();
};


// -------------------------
// BOTÕES DO TOPO
// -------------------------

document.getElementById("saveBtn").onclick = () => {

    alert("Simulação guardada.");

};


document.getElementById("scenarioBtn").onclick = () => {

    alert("Altere os valores para simular outro cenário.");

};


// -------------------------
// INICIAR
// -------------------------

calcular();