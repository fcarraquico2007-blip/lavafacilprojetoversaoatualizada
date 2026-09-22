<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Simulador de IRC</title>
  
    <link rel="stylesheet" href="public/assets/css/irc.css">
     

   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
      
</head>

<body>


    <div class="page">
        <header>
            <div>
                <h1><i class="bi bi-calculator"></i> Simulador de IRC</h1>
                <p>Calcule de forma simples e automática o Imposto sobre o Rendimento das Pessoas Coletivas.</p>
            </div>
            <div><button id="saveBtn">Guardar Simulação</button><button class="primary" id="scenarioBtn">Simular
                    Cenário</button></div>
        </header>
        <section class="cards">
            <div class="card ">€<div><small>Resultado Contabilístico</small><b id="topResultado"></b><em>Rendimentos
                        - Gastos</em></div>
            </div>
            <div class="card ">↗<div><small>Lucro Tributável</small><b id="topLucro"></b><em>Após ajustamentos
                        fiscais</em></div>
            </div>
            <div class="card ">▣<div><small>IRC Estimado</small><b id="topIRC"></b><em>Imposto sobre o
                        rendimento</em></div>
            </div>
            <div class="card ">€<div><small>Valor Final</small><b id="topFinal"></b><em id="topEstado"></em></div>
            </div>
        </section>
        <main class="grid">
            <section>
                <div class="panel">
                    <h2><i>1</i> Rendimentos</h2><label>Vendas e Prestações de Serviços<input id="vendas"
                            value="230000"></label><label>Subsídios à Exploração<input id="subsidios"
                            value="0"></label><label>Outros Rendimentos<input id="outrosRendimentos"
                            value="20000"></label>
                    <div class="total">Total de Rendimentos <b id="totalRendimentos"></b></div>
                </div>
                <div class="panel">
                    <h2><i>2</i> Gastos</h2><label>Compras<input id="compras" value="40000"></label><label>Fornecimentos
                        e Serviços Externos<input id="fse" value="60000"></label><label>Gastos com Pessoal<input
                            id="pessoal" value="30000"></label><label>Depreciações e Amortizações<input
                            id="depreciacoes" value="10000"></label><label>Juros e Gastos Similares<input id="juros"
                            value="5000"></label><label>Outros Gastos<input id="outrosGastos" value="5000"></label>
                    <div class="total">Total de Gastos <b id="totalGastos"></b></div>
                </div>
            </section>
            <section>
                <div class="panel">
                    <h2><i>3</i> Resultado Contabilístico</h2>
                    <p>Rendimentos <b id="resRendimentos"></b></p>
                    <p>(-) Gastos <b id="resGastos"></b></p>
                    <div class="big">Resultado Contabilístico<b id="resultado"></b></div>
                </div>
                <div class="panel">
                    <h2><i>4</i> Ajustamentos Fiscais</h2>
                    <fieldset class="red">
                        <h3>Acréscimos Fiscais</h3><label>Despesas não dedutíveis<input id="naoDedutiveis"
                                value="5000"></label><label>Outros acréscimos<input id="outrosAcrescimos"
                                value="0"></label><b>Total Acréscimos <span id="totalAcrescimos"></span></b>
                    </fieldset>
                    <fieldset>
                        <h3>Deduções Fiscais</h3><label>Benefícios Fiscais<input id="beneficios"
                                value="5000"></label><label>Prejuízos Fiscais<input id="prejuizos"
                                value="5000"></label><label>Outras deduções<input id="outrasDeducoes"
                                value="0"></label><b>Total Deduções <span id="totalDeducoes"></span></b>
                    </fieldset>
                    <div class="profit">Lucro Tributável<b id="lucroTributavel"></b><small>Resultado + Acréscimos -
                            Deduções</small></div>
                </div>
            </section>
            <section>
                <div class="panel">
                    <h2><i>5</i> Taxas e Derramas</h2><label>Taxa de IRC (%)<select id="taxaIRC">
                            <option value="20">20%</option>
                            <option value="21">21%</option>
                        </select></label><small>Taxa normal de IRC</small><label>Derrama Municipal (%)<select
                            id="derramaMunicipal">
                            <option value="1.5">1,50%</option>
                            <option value="0">0%</option>
                        </select></label><small>Definida pelo município</small><label>Derrama Estadual (%)<select
                            id="derramaEstadual">
                            <option value="0">0%</option>
                            <option value="3">3%</option>
                            <option value="5">5%</option>
                        </select></label><small>Aplicável conforme o lucro</small><label>Tributações Autónomas<input
                            id="autonomas" value="0"></label>
                </div>
                <div class="panel">
                    <h2><i>6</i> Pagamentos por Conta</h2><label>Pagamentos por Conta<input id="pagamentos"
                            value="15000"></label><label>Retenções na Fonte<input id="retencoes" value="0"></label>
                    <div class="total">Total Pagamentos <b id="totalPagamentos"></b></div>
                </div>
            </section>
            <aside class="summary">
                <h2>Resumo do Cálculo</h2>
                <div>Lucro Tributável <b id="sLucro"></b></div>
                <div>IRC (<span id="sTaxa"></span>%) <b id="sIRC"></b></div>
                <div>Derrama Municipal <b id="sDM"></b></div>
                <div>Derrama Estadual <b id="sDE"></b></div>
                <div>Tributações Autónomas <b id="sAuto"></b></div><strong>Total de Imposto <b
                        id="totalImposto"></b></strong>
                <h2 class="gold">Pagamentos e Retenções</h2>
                <div>Pagamentos por Conta <b id="sPagamentos"></b></div>
                <div>Retenções na Fonte <b id="sRetencoes"></b></div><strong class="redtext">Total de Pagamentos <b
                        id="sTotalPagamentos"></b></strong>
                <div class="final"><span>Imposto a<br><b id="finalLabel"></b></span><strong id="finalValue"></strong>
                </div><small>ⓘ Este valor é uma estimativa. O cálculo final deverá ser confirmado no Modelo 22.</small>
            </aside>
        </main>
        <footer>ⓘ Simulação baseada na legislação em vigor. <button id="clearBtn">Limpar Campos</button></footer>
    </div>
    <script src="assets/js/irc.js"></script>
</body>

</html>