/* assets/js/agendar.js */

let servicoAtualId = null; // cod_tiposervico atualmente escolhido no select

function obterServicoAtual() {
    return servicoAtualId && SERVICOS[servicoAtualId] ? SERVICOS[servicoAtualId] : null;
}

/* Mostra/esconde os blocos de campos consoante o serviço escolhido. */
function aplicarServicoSelecionado() {
    const select = document.getElementById("servicoSelecionado");
    servicoAtualId = select.value || null;

    const servico = obterServicoAtual();
    const semServico = !servico;

    document.getElementById("avisoSemServico").style.display = semServico ? "block" : "none";
    document.getElementById("btnContinuar").classList.toggle("oculto", semServico);
    document.getElementById("blocoPreco").classList.toggle("oculto", semServico);

    document.getElementById("tituloServico").textContent = servico ? servico.nome : "Agendar serviço";

    // Campos sempre necessários assim que há um serviço escolhido
    ["blocoLocalidade", "blocoData", "blocoHora"].forEach(function (blocoId) {
        document.getElementById(blocoId).classList.toggle("oculto", semServico);
    });

    // Campos que dependem da configuração de cada serviço
    const mostrarKg = servico ? servico.mostrar_kg : false;
    document.getElementById("blocoKg").classList.toggle("oculto", !mostrarKg);
    document.getElementById("blocoTipoRoupa").classList.toggle("oculto", !mostrarKg);

    const mostrarExtras = servico ? servico.mostrar_extras : false;
    document.getElementById("blocoExtras").classList.toggle("oculto", !mostrarExtras);

    const mostrarRecolhaEntrega = servico ? servico.mostrar_recolha_entrega : false;
    document.getElementById("blocoRecolha").classList.toggle("oculto", !mostrarRecolhaEntrega);
    document.getElementById("blocoEntrega").classList.toggle("oculto", !mostrarRecolhaEntrega);

    atualizarPreco();
}

function calcularEObterPreco() {
    const servico = obterServicoAtual();
    if (!servico) {
        return { preco: 0, precoFormatado: "0.00€" };
    }

    const kgEl = document.getElementById("kg");
    const tipoEl = document.getElementById("tipoRoupa");
    const extrasEl = document.getElementById("extras");
    const recolhaEl = document.getElementById("recolha");
    const entregaEl = document.getElementById("entrega");
    const localidadeEl = document.getElementById("localidade");
    const dataEl = document.getElementById("dataServico");
    const horaEl = document.getElementById("horaServico");

    const kg = servico.mostrar_kg && kgEl ? (parseFloat(kgEl.value) || 0) : 0;
    const tipo = servico.mostrar_kg && tipoEl ? tipoEl.value : "";
    const extras = servico.mostrar_extras && extrasEl ? extrasEl.value : "Nenhum";
    const recolha = servico.mostrar_recolha_entrega && recolhaEl ? recolhaEl.value : "Loja";
    const entrega = servico.mostrar_recolha_entrega && entregaEl ? entregaEl.value : "Loja";
    const localidade = localidadeEl ? localidadeEl.value : "";
    const data = dataEl ? dataEl.value : "";
    const hora = horaEl ? horaEl.value : "";

    let preco = servico.mostrar_kg ? (kg * Number(servico.preco_kg)) : Number(servico.preco_fixo);

    if (servico.mostrar_extras) {
        if (extras === "Perfume" || extras === "Dobrar") preco += 1;
        if (extras === "Urgente") preco += 3;
    }

    if (servico.mostrar_recolha_entrega) {
        if (recolha === "Casa") preco += 2;
        if (entrega === "Casa") preco += 2;
    }

    return {
        kg, tipo, extras, recolha, entrega, localidade, data, hora,
        preco,
        precoFormatado: preco.toFixed(2) + "€"
    };
}

function atualizarPreco() {
    const precoEl = document.getElementById("precoTotal");
    if (!precoEl) return;

    const servico = obterServicoAtual();
    if (!servico) {
        precoEl.textContent = "0.00€";
        return;
    }

    const dados = calcularEObterPreco();

    if (servico.mostrar_kg && dados.kg <= 0) {
        precoEl.textContent = "0.00€";
        return;
    }

    precoEl.textContent = dados.precoFormatado;
}

function formatarData(data) {
    if (!data) return "";
    const partes = data.split("-");
    return partes.length === 3
        ? `${partes[2]}/${partes[1]}/${partes[0]}`
        : data;
}

function preencherElemento(id, valor) {
    const el = document.getElementById(id);
    if (el) el.textContent = valor;
}

function mostrarLinha(id, mostrar) {
    const el = document.getElementById(id);
    if (el) el.style.display = mostrar ? "" : "none";
}

function mostrarResumo() {
    const servico = obterServicoAtual();
    if (!servico) {
        alert("Escolhe primeiro um serviço.");
        return;
    }

    const dados = calcularEObterPreco();

    if (servico.mostrar_kg) {
        if (!Number.isFinite(dados.kg) || dados.kg <= 0) {
            alert("Por favor, introduza um peso válido em Kg.");
            document.getElementById("kg")?.focus();
            return;
        }
        if (dados.kg > 30) {
            alert("O peso máximo permitido é 30 Kg.");
            document.getElementById("kg")?.focus();
            return;
        }
    }

    if (!dados.data) {
        alert("Por favor, selecione uma data para o serviço.");
        document.getElementById("dataServico")?.focus();
        return;
    }

    const dataSelecionada = new Date(dados.data + "T00:00:00");
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    if (dataSelecionada < hoje) {
        alert("Por favor, selecione uma data igual ou posterior a hoje.");
        document.getElementById("dataServico")?.focus();
        return;
    }

    preencherElemento("rServico", servico.nome);
    preencherElemento("rData", formatarData(dados.data));
    preencherElemento("rHora", dados.hora);

    mostrarLinha("linhaRKg", servico.mostrar_kg);
    mostrarLinha("linhaRTipo", servico.mostrar_kg);
    if (servico.mostrar_kg) {
        preencherElemento("rKg", dados.kg + " Kg");
        preencherElemento("rTipo", dados.tipo);
    }

    mostrarLinha("linhaRExtras", servico.mostrar_extras);
    if (servico.mostrar_extras) {
        preencherElemento("rExtras", dados.extras);
    }

    mostrarLinha("linhaRRecolha", servico.mostrar_recolha_entrega);
    mostrarLinha("linhaREntrega", servico.mostrar_recolha_entrega);
    if (servico.mostrar_recolha_entrega) {
        preencherElemento("rRecolha", dados.recolha);
        preencherElemento("rEntrega", dados.entrega);
    }

    preencherElemento("rLocalidade", dados.localidade);
    preencherElemento("rPreco", dados.precoFormatado);
    preencherElemento("precoTotal", dados.precoFormatado);

    const resumo = document.getElementById("resumo");
    if (!resumo) {
        alert("Erro: a área do resumo não foi encontrada na página.");
        return;
    }

    resumo.style.display = "";
    resumo.classList.add("mostrar");
    resumo.scrollIntoView({ behavior: "smooth", block: "start" });
}

async function gravarPedido() {
    const servico = obterServicoAtual();
    if (!servico) {
        throw new Error("Escolhe um serviço antes de continuar.");
    }

    const dados = calcularEObterPreco();

    if (servico.mostrar_kg && dados.kg <= 0) {
        throw new Error("Introduza um peso válido antes de continuar.");
    }

    if (!dados.data) {
        throw new Error("Selecione uma data para o serviço.");
    }

    const corpo = {
        tipoServicoId: Number(servicoAtualId),
        kg: dados.kg,
        tipoRoupa: dados.tipo,
        extras: dados.extras,
        recolha: dados.recolha,
        entrega: dados.entrega,
        localidade: dados.localidade,
        data: dados.data,
        hora: dados.hora,
        preco: dados.preco
    };

    const resposta = await fetch("processar_pedido.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify(corpo)
    });

    let json;
    try {
        json = await resposta.json();
    } catch (e) {
        throw new Error("O servidor devolveu uma resposta inválida.");
    }

    if (!resposta.ok || !json.sucesso) {
        throw new Error(json.erro || "Não foi possível gravar o pedido.");
    }

    return json;
}

function mostrarErroPedido(mensagem) {
    const el = document.getElementById("erroPedido");
    if (!el) {
        alert(mensagem);
        return;
    }
    el.textContent = mensagem;
    el.style.display = "block";
}

function esconderErroPedido() {
    const el = document.getElementById("erroPedido");
    if (el) {
        el.textContent = "";
        el.style.display = "none";
    }
}

async function irParaPagamentoLoja() {
    esconderErroPedido();
    try {
        const resultado = await gravarPedido();
        if (!resultado.id_pedido) throw new Error("O pedido foi criado, mas não foi devolvido um ID.");
        window.location.href = "confirmacaoloja.php?id=" + encodeURIComponent(resultado.id_pedido);
    } catch (erro) {
        mostrarErroPedido(erro.message);
    }
}

async function irParaPagamentoOnline() {
    esconderErroPedido();
    try {
        const resultado = await gravarPedido();
        if (!resultado.id_pedido) throw new Error("O pedido foi criado, mas não foi devolvido um ID.");
        window.location.href = "confirmacaoonline.php?id=" + encodeURIComponent(resultado.id_pedido);
    } catch (erro) {
        mostrarErroPedido(erro.message);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("servicoSelecionado");
    select.addEventListener("change", aplicarServicoSelecionado);

    const camposQueAfetamPreco = [
        "kg", "tipoRoupa", "extras", "recolha", "entrega",
        "localidade", "dataServico", "horaServico"
    ];
    camposQueAfetamPreco.forEach(function (id) {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener("change", atualizarPreco);
            el.addEventListener("input", atualizarPreco);
        }
    });

    // Data mínima = hoje
    const dataEl = document.getElementById("dataServico");
    if (dataEl) {
        const hoje = new Date();
        const ano = hoje.getFullYear();
        const mes = String(hoje.getMonth() + 1).padStart(2, "0");
        const dia = String(hoje.getDate()).padStart(2, "0");
        dataEl.min = `${ano}-${mes}-${dia}`;
    }

    // Se a página abriu com ?id=X válido, o <select> já vem
    // pré-selecionado (feito em PHP) — só falta aplicar os campos.
    if (ID_INICIAL && SERVICOS[ID_INICIAL]) {
        select.value = String(ID_INICIAL);
    }
    aplicarServicoSelecionado();
});