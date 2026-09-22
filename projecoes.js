// ---------- RENDIMENTOS E GASTOS ----------

function atualizarPrevisoes() {
    let rendimento = Number(document.getElementById("rendimentoAtual").value);
    let variacaoR = Number(document.getElementById("rendimentoVariacao").value);

    let gasto = Number(document.getElementById("gastoAtual").value);
    let variacaoG = Number(document.getElementById("gastoVariacao").value);

    let rendimentoPrevisto = rendimento * (1 + variacaoR / 100);
    let gastoPrevisto = gasto * (1 + variacaoG / 100);

    document.getElementById("rendimentoPrevisto").textContent =
        rendimentoPrevisto.toFixed(2) + " €";

    document.getElementById("gastoPrevisto").textContent =
        gastoPrevisto.toFixed(2) + " €";

    document.getElementById("totalRendimentos").textContent =
        rendimentoPrevisto.toFixed(2) + " €";

    document.getElementById("totalGastos").textContent =
        gastoPrevisto.toFixed(2) + " €";

    document.getElementById("saldoPrevisto").textContent =
        (rendimentoPrevisto - gastoPrevisto).toFixed(2) + " €";
}


function alterarRendimento(valor) {
    let campo = document.getElementById("rendimentoVariacao");

    campo.value = Number(campo.value) + valor;

    atualizarPrevisoes();
}


function alterarGasto(valor) {
    let campo = document.getElementById("gastoVariacao");

    campo.value = Number(campo.value) + valor;

    atualizarPrevisoes();
}


// Atualizar quando o utilizador escreve nos campos
document.getElementById("rendimentoAtual").oninput = atualizarPrevisoes;
document.getElementById("rendimentoVariacao").oninput = atualizarPrevisoes;
document.getElementById("gastoAtual").oninput = atualizarPrevisoes;
document.getElementById("gastoVariacao").oninput = atualizarPrevisoes;


// ---------- IVA ----------

function calcularIVA() {

    let liquidado = Number(
        document.getElementById("ivaLiquidado").value
    );

    let dedutivel = Number(
        document.getElementById("ivaDedutivel").value
    );

    let resultado = liquidado - dedutivel;

    let valor = Math.abs(resultado).toFixed(2) + " €";

    document.getElementById("ivaTitulo").textContent =
        resultado >= 0 ? "IVA a Pagar" : "IVA a Recuperar";

    document.getElementById("ivaResultado").textContent = valor;

    document.getElementById("resLiquidado").textContent =
        liquidado.toFixed(2) + " €";

    document.getElementById("resDedutivel").textContent =
        dedutivel.toFixed(2) + " €";

    document.getElementById("resDiferenca").textContent =
        valor;

    document.getElementById("calcLiquidado").textContent =
        liquidado.toFixed(2) + " €";

    document.getElementById("calcDedutivel").textContent =
        dedutivel.toFixed(2) + " €";

    document.getElementById("calcResultado").textContent =
        valor;
}


// ---------- INICIAR ----------

atualizarPrevisoes();
calcularIVA();