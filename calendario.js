// =====================================================
// calendario.js
// Calendário de agendamentos (versão simples)
//
// Nota: os nomes entre aspas nos getElementById (ex.: "calendar")
// e nas classes (ex.: "day") vêm do calendario.php e do calendario.css.
// Tudo o resto está em português.
// =====================================================

document.addEventListener("DOMContentLoaded", function () {

    // -------------------------------------------------
    // 1. ELEMENTOS DA PÁGINA
    // -------------------------------------------------
    const calendario = document.getElementById("calendar");
    const diasSemana = document.querySelector(".weekdays");
    const tituloMes = document.getElementById("monthYear");
    const miniCalendario = document.getElementById("miniCalendar");
    const miniTitulo = document.getElementById("miniMonth");
    const listaContainer = document.getElementById("listContainer");
    const formulario = document.getElementById("appointmentForm");


    // -------------------------------------------------
    // 2. DADOS
    // -------------------------------------------------
    const hoje = new Date();

    // Mês que está a ser mostrado (sempre no dia 1)
    let mesAtual = new Date(hoje.getFullYear(), hoje.getMonth(), 1);

    // Agendamento em que o utilizador clicou por último
    let agendamentoSelecionado = null;

    // Número do próximo agendamento a criar
    let proximoId = 6;

    // Cor de cada estado (classes do calendario.css)
    const coresEstado = {
        agendado: "orange",
        preparacao: "blue",
        concluido: "green",
        cancelado: "red"
    };

    // Texto de cada estado
    const nomesEstado = {
        agendado: "Agendado",
        preparacao: "Em preparação",
        concluido: "Concluído",
        cancelado: "Cancelado"
    };

    // Agendamentos de exemplo. As datas são sempre do mês atual,
    // por isso aparecem logo no calendário.
    // Os nomes das propriedades seguem as colunas da tabela "agendamentos".
    const agendamentos = [
        {
            id: 1,
            data: dataDoMesAtual(19),
            hora: "09:00",
            cliente: "João Silva",
            telefone: "",
            servico: "Lavagem",
            colaborador: "João",
            peso: 5,
            valor: 10,
            descricao: "",
            estado: "agendado"
        },
        {
            id: 2,
            data: dataDoMesAtual(19),
            hora: "11:00",
            cliente: "Maria Costa",
            telefone: "",
            servico: "Lavagem + Secagem",
            colaborador: "Maria",
            peso: 8,
            valor: 18,
            descricao: "",
            estado: "preparacao"
        },
        {
            id: 3,
            data: dataDoMesAtual(21),
            hora: "15:00",
            cliente: "Ana Pereira",
            telefone: "",
            servico: "Engomadoria",
            colaborador: "João",
            peso: 4,
            valor: 13,
            descricao: "",
            estado: "concluido"
        },
        {
            id: 4,
            data: dataDoMesAtual(25),
            hora: "10:30",
            cliente: "Pedro Santos",
            telefone: "",
            servico: "Recolha",
            colaborador: "Maria",
            peso: 3,
            valor: 8,
            descricao: "",
            estado: "cancelado"
        },
        {
            id: 5,
            data: dataDoMesAtual(27),
            hora: "09:30",
            cliente: "Rita Alves",
            telefone: "",
            servico: "Lavagem",
            colaborador: "João",
            peso: 6,
            valor: 12,
            descricao: "",
            estado: "agendado"
        }
    ];


    // -------------------------------------------------
    // 3. FUNÇÕES PEQUENAS DE APOIO
    // -------------------------------------------------

    // Cria uma data em texto: "2026-09-05" (o mês começa em 0)
    function criarData(ano, mes, dia) {
        return ano + "-" + String(mes + 1).padStart(2, "0") + "-" + String(dia).padStart(2, "0");
    }

    // Data de um dia do mês atual
    function dataDoMesAtual(dia) {
        return criarData(hoje.getFullYear(), hoje.getMonth(), dia);
    }

    // "2026-09-05" passa a "05/09/2026"
    function formatarData(data) {
        const partes = data.split("-");
        return partes[2] + "/" + partes[1] + "/" + partes[0];
    }

    // "Setembro de 2026"
    function nomeDoMes() {
        const texto = mesAtual.toLocaleDateString("pt-PT", { month: "long", year: "numeric" });
        return texto.charAt(0).toUpperCase() + texto.slice(1);
    }

    // Impede que o texto escrito pelo utilizador seja lido como HTML
    function escapar(texto) {
        const div = document.createElement("div");
        div.textContent = texto;
        return div.innerHTML;
    }

    // Mostrar e esconder elementos
    function mostrar(elemento) {
        elemento.classList.remove("hidden");
        elemento.style.display = "";
    }

    function esconder(elemento) {
        elemento.style.display = "none";
    }

    // Abrir e fechar janelas (modais) do Bootstrap
    function abrirModal(id) {
        bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show();
    }

    function fecharModal(id) {
        bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).hide();
    }

    // Pede um número ao utilizador. Devolve null se cancelar ou se for inválido.
    function pedirNumero(mensagem, valorAtual) {
        const texto = prompt(mensagem, valorAtual);

        if (texto === null) {
            return null;
        }

        const numero = Number(texto.replace(",", "."));

        if (isNaN(numero) || numero < 0) {
            alert("Valor inválido.");
            return null;
        }

        return numero;
    }


    // -------------------------------------------------
    // 4. AGENDAMENTOS DO MÊS (já com os filtros aplicados)
    // -------------------------------------------------
    function agendamentosDoMes() {
        const servico = document.getElementById("serviceFilter").value;
        const estado = document.getElementById("statusFilter").value;
        const colaborador = document.getElementById("workerFilter").value;

        // Ex.: "2026-09"
        const prefixo = criarData(mesAtual.getFullYear(), mesAtual.getMonth(), 1).slice(0, 7);

        const resultado = [];

        for (let i = 0; i < agendamentos.length; i++) {
            const ag = agendamentos[i];

            if (ag.data.slice(0, 7) !== prefixo) continue;
            if (servico !== "" && ag.servico !== servico) continue;
            if (estado !== "" && ag.estado !== estado) continue;
            if (colaborador !== "" && ag.colaborador !== colaborador) continue;

            resultado.push(ag);
        }

        // Ordenar por data e hora
        resultado.sort(function (a, b) {
            return (a.data + a.hora).localeCompare(b.data + b.hora);
        });

        return resultado;
    }


    // -------------------------------------------------
    // 5. CALENDÁRIO GRANDE
    // -------------------------------------------------

    // Cria uma marcação (a caixa colorida dentro de um dia)
    function criarEvento(ag) {
        const evento = document.createElement("div");
        evento.className = "event " + coresEstado[ag.estado];
        evento.innerHTML = "<strong>" + ag.hora + "</strong> " + escapar(ag.servico);

        evento.onclick = function (e) {
            e.stopPropagation(); // não abrir também o "Novo Agendamento"
            mostrarDetalhes(ag);
        };

        return evento;
    }

    // Cria a caixa de um dia, com as marcações desse dia
    function criarCaixaDoDia(data, numero, lista) {
        const caixa = document.createElement("div");
        caixa.className = "day";

        const numeroDia = document.createElement("div");
        numeroDia.className = "day-number";
        numeroDia.textContent = numero;
        caixa.appendChild(numeroDia);

        for (let i = 0; i < lista.length; i++) {
            if (lista[i].data === data) {
                caixa.appendChild(criarEvento(lista[i]));
            }
        }

        caixa.onclick = function () {
            abrirNovoAgendamento(data);
        };

        return caixa;
    }

    function desenharCalendario() {
        const ano = mesAtual.getFullYear();
        const mes = mesAtual.getMonth();

        // Em que coluna cai o dia 1 (segunda = 0 ... domingo = 6)
        const primeiroDia = (new Date(ano, mes, 1).getDay() + 6) % 7;
        const diasNoMes = new Date(ano, mes + 1, 0).getDate();
        const lista = agendamentosDoMes();

        tituloMes.textContent = nomeDoMes();
        calendario.innerHTML = "";

        // Caixas vazias antes do dia 1
        for (let i = 0; i < primeiroDia; i++) {
            const vazio = document.createElement("div");
            vazio.className = "day empty";
            calendario.appendChild(vazio);
        }

        // Um dia de cada vez
        for (let dia = 1; dia <= diasNoMes; dia++) {
            const data = criarData(ano, mes, dia);
            calendario.appendChild(criarCaixaDoDia(data, dia, lista));
        }
    }


    // -------------------------------------------------
    // 6. MINI CALENDÁRIO (do lado direito)
    // -------------------------------------------------
    function desenharMiniCalendario() {
        const ano = mesAtual.getFullYear();
        const mes = mesAtual.getMonth();
        const primeiroDia = (new Date(ano, mes, 1).getDay() + 6) % 7;
        const diasNoMes = new Date(ano, mes + 1, 0).getDate();

        miniTitulo.textContent = nomeDoMes();
        miniCalendario.innerHTML = "";

        for (let i = 0; i < primeiroDia; i++) {
            miniCalendario.appendChild(document.createElement("span"));
        }

        for (let dia = 1; dia <= diasNoMes; dia++) {
            const data = criarData(ano, mes, dia);
            const botao = document.createElement("span");
            botao.textContent = dia;

            // Destaca o dia do agendamento escolhido
            if (agendamentoSelecionado && agendamentoSelecionado.data === data) {
                botao.classList.add("sel");
            }

            botao.onclick = function () {
                abrirNovoAgendamento(data);
            };

            miniCalendario.appendChild(botao);
        }
    }


    // -------------------------------------------------
    // 7. RESUMO DO MÊS
    // -------------------------------------------------
    function atualizarResumo() {
        const lista = agendamentosDoMes();

        let concluidos = 0;
        let preparacao = 0;
        let cancelados = 0;
        let valorTotal = 0;

        for (let i = 0; i < lista.length; i++) {
            const ag = lista[i];

            if (ag.estado === "concluido") concluidos++;
            if (ag.estado === "preparacao") preparacao++;
            if (ag.estado === "cancelado") cancelados++;

            // Os cancelados não contam para o valor
            if (ag.estado !== "cancelado") {
                valorTotal += ag.valor;
            }
        }

        document.getElementById("totalCount").textContent = lista.length;
        document.getElementById("doneCount").textContent = concluidos;
        document.getElementById("prepCount").textContent = preparacao;
        document.getElementById("cancelCount").textContent = cancelados;
        document.getElementById("totalValue").textContent =
            valorTotal.toLocaleString("pt-PT", { minimumFractionDigits: 2 }) + " €";
    }


    // -------------------------------------------------
    // 8. VISTA EM LISTA
    // -------------------------------------------------
    function desenharLista() {
        const lista = agendamentosDoMes();
        let html = "";

        if (lista.length === 0) {
            html = "<p>Não há agendamentos neste mês.</p>";
        }

        for (let i = 0; i < lista.length; i++) {
            const ag = lista[i];

            html += '<div class="list-row">' +
                '<strong>' + formatarData(ag.data) + '</strong>' +
                '<div><strong>' + escapar(ag.cliente) + '</strong>' +
                '<small>' + escapar(ag.servico) + '</small></div>' +
                '<span>' + ag.hora + '</span>' +
                '<span class="status">' + nomesEstado[ag.estado] + '</span>' +
                '<strong>' + ag.valor.toFixed(2) + ' €</strong>' +
                '</div>';
        }

        listaContainer.innerHTML = html;
    }


    // -------------------------------------------------
    // 9. DESENHAR TUDO DE NOVO
    // -------------------------------------------------
    function desenharTudo() {
        desenharCalendario();
        desenharMiniCalendario();
        atualizarResumo();
        desenharLista();
    }


    // -------------------------------------------------
    // 10. DETALHES DE UM AGENDAMENTO
    // -------------------------------------------------
    function mostrarDetalhes(ag) {
        agendamentoSelecionado = ag;

        document.getElementById("details").innerHTML =
            "<p><strong>Cliente:</strong> " + escapar(ag.cliente) + "</p>" +
            "<p><strong>Telefone:</strong> " + escapar(ag.telefone || "-") + "</p>" +
            "<p><strong>Data:</strong> " + formatarData(ag.data) + "</p>" +
            "<p><strong>Hora:</strong> " + ag.hora + "</p>" +
            "<p><strong>Serviço:</strong> " + escapar(ag.servico) + "</p>" +
            "<p><strong>Colaborador:</strong> " + escapar(ag.colaborador) + "</p>" +
            "<p><strong>Peso:</strong> " + ag.peso + " kg</p>" +
            "<p><strong>Preço:</strong> " + ag.valor.toFixed(2) + " €</p>" +
            "<p><strong>Estado:</strong> " + nomesEstado[ag.estado] + "</p>" +
            "<p><strong>Observações:</strong> " + escapar(ag.descricao || "-") + "</p>";

        abrirModal("detailsModal");
        desenharMiniCalendario();
    }

    // Botão "Aceitar / Preparação"
    document.getElementById("prepBtn").onclick = function () {
        if (agendamentoSelecionado) {
            agendamentoSelecionado.estado = "preparacao";
            fecharModal("detailsModal");
            desenharTudo();
        }
    };

    // Botão "Serviço Concluído"
    document.getElementById("doneBtn").onclick = function () {
        if (agendamentoSelecionado) {
            agendamentoSelecionado.estado = "concluido";
            fecharModal("detailsModal");
            desenharTudo();
        }
    };


    // -------------------------------------------------
    // 11. NOVO AGENDAMENTO
    // -------------------------------------------------

    // Abre a janela com a data já preenchida
    function abrirNovoAgendamento(data) {
        document.getElementById("date").value = data;
        abrirModal("appointmentModal");
    }

    // Botão "Novo Agendamento" (usa a data de hoje)
    document.getElementById("newBtn").onclick = function () {
        abrirNovoAgendamento(criarData(hoje.getFullYear(), hoje.getMonth(), hoje.getDate()));
    };

    // Botão "Guardar" do formulário
    formulario.onsubmit = function (e) {
        e.preventDefault(); // não recarregar a página

        const novo = {
            id: proximoId,
            data: document.getElementById("date").value,
            hora: document.getElementById("time").value,
            cliente: document.getElementById("client").value,
            telefone: document.getElementById("phone").value,
            servico: document.getElementById("service").value,
            colaborador: document.getElementById("worker").value,
            peso: Number(document.getElementById("weight").value),
            valor: Number(document.getElementById("price").value),
            descricao: document.getElementById("notes").value,
            estado: "agendado"
        };

        proximoId++;
        agendamentos.push(novo);

        formulario.reset();
        fecharModal("appointmentModal");

        // Ir para o mês do novo agendamento
        const partes = novo.data.split("-");
        mesAtual = new Date(Number(partes[0]), Number(partes[1]) - 1, 1);

        desenharTudo();
    };


    // -------------------------------------------------
    // 12. AJUSTAR PESO E PREÇO
    // -------------------------------------------------
    document.getElementById("weightBtn").onclick = function () {
        if (!agendamentoSelecionado) {
            alert("Clique primeiro num agendamento do calendário.");
            return;
        }

        const peso = pedirNumero("Peso real (kg):", agendamentoSelecionado.peso);

        if (peso !== null) {
            agendamentoSelecionado.peso = peso;
            desenharTudo();
        }
    };

    document.getElementById("priceBtn").onclick = function () {
        if (!agendamentoSelecionado) {
            alert("Clique primeiro num agendamento do calendário.");
            return;
        }

        const valor = pedirNumero("Preço final (€):", agendamentoSelecionado.valor);

        if (valor !== null) {
            agendamentoSelecionado.valor = valor;
            desenharTudo();
        }
    };


    // -------------------------------------------------
    // 13. MUDAR DE MÊS
    // -------------------------------------------------
    function mudarMes(quantidade) {
        mesAtual = new Date(mesAtual.getFullYear(), mesAtual.getMonth() + quantidade, 1);
        desenharTudo();
    }

    document.getElementById("prevMonth").onclick = function () { mudarMes(-1); };
    document.getElementById("nextMonth").onclick = function () { mudarMes(1); };
    document.getElementById("miniPrev").onclick = function () { mudarMes(-1); };
    document.getElementById("miniNext").onclick = function () { mudarMes(1); };

    // Botão "Hoje"
    document.getElementById("todayBtn").onclick = function () {
        mesAtual = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
        desenharTudo();
    };


    // -------------------------------------------------
    // 14. FILTROS
    // -------------------------------------------------
    document.getElementById("serviceFilter").onchange = desenharTudo;
    document.getElementById("statusFilter").onchange = desenharTudo;
    document.getElementById("workerFilter").onchange = desenharTudo;

    // Botão "Filtros": leva o cursor para o primeiro filtro
    document.getElementById("filterBtn").onclick = function () {
        document.getElementById("serviceFilter").focus();
    };


    // -------------------------------------------------
    // 15. TROCAR ENTRE CALENDÁRIO E LISTA
    // -------------------------------------------------
    document.getElementById("calendarView").onclick = function () {
        mostrar(calendario);
        mostrar(diasSemana);
        esconder(listaContainer);

        document.getElementById("calendarView").classList.add("active");
        document.getElementById("listView").classList.remove("active");
    };

    document.getElementById("listView").onclick = function () {
        esconder(calendario);
        esconder(diasSemana);
        mostrar(listaContainer);

        document.getElementById("listView").classList.add("active");
        document.getElementById("calendarView").classList.remove("active");

        desenharLista();
    };


    // -------------------------------------------------
    // 16. COMEÇAR
    // -------------------------------------------------
    esconder(listaContainer); // a lista começa escondida
    desenharTudo();

});