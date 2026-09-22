<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LavaFácil - Projeções</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="public/assets/css/dashboard.css">
  <link rel="stylesheet" href="public/assets/css/projecoes.css">

  <!-- Corrige o item ativo do menu nesta página (o dashboard.css usa :first-child para o Dashboard) -->
  <style>
    .sidebar nav a:first-child{
      background: transparent;
      color: #5f6b82;
    }
    .sidebar nav a:first-child:hover{
      background: #246BFD;
      color: #fff;
    }
    .sidebar nav a.active{
      background: #246BFD;
      color: #fff;
    }

    /* Centra o conteúdo das projeções dentro da área disponível */
    .content{
      display: flex;
      justify-content: center;
    }

    .content .projecoes{
      width: 100%;
      max-width: 1100px;
    }
  </style>
</head>
<body>

    <?php include __DIR__ . '/layoutfrancisco/sidebar.php'; ?>

  <main class="content">
    <section class="projecoes">

        <h1>Projeções</h1>
        <p class="subtitulo">Simuladores financeiros da empresa</p>

        <!-- ================= RENDIMENTOS E GASTOS ================= -->

        <div class="simulador">


            <div class="caixa rendimento">
                <h3>💰 SIMULADOR DE RENDIMENTOS</h3>

                <div class="campos">
                    <div>
                        <label>Valor Atual (€)</label>
                        <input id="rendimentoAtual" type="number" value="2000">
                    </div>

                    <div>
                        <label>Variação (%)</label>
                        <input id="rendimentoVariacao" type="number" value="10">
                    </div>

                    <button onclick="alterarRendimento(1)">＋</button>
                    <button onclick="alterarRendimento(-1)">−</button>

                    <div class="resultado verde">
                        <label>Valor Previsto (€)</label>
                        <strong id="rendimentoPrevisto">2 200,00 €</strong>
                    </div>
                </div>
            </div>

            <div class="caixa gasto">
                <h3>💸 SIMULADOR DE GASTOS</h3>

                <div class="campos">
                    <div>
                        <label>Valor Atual (€)</label>
                        <input id="gastoAtual" type="number" value="1500">
                    </div>

                    <div>
                        <label>Variação (%)</label>
                        <input id="gastoVariacao" type="number" value="15">
                    </div>

                    <button onclick="alterarGasto(1)">＋</button>
                    <button onclick="alterarGasto(-1)">−</button>

                    <div class="resultado vermelho">
                        <label>Valor Previsto (€)</label>
                        <strong id="gastoPrevisto">1 725,00 €</strong>
                    </div>
                </div>
            </div>

            <div class="totais">
                <div>
                    <span>Total Rendimentos Previsto</span>
                    <strong id="totalRendimentos">2 200,00 €</strong>
                </div>

                <div>
                    <span>Total Gastos Previsto</span>
                    <strong id="totalGastos">1 725,00 €</strong>
                </div>

                <div>
                    <span>Saldo Previsto</span>
                    <strong id="saldoPrevisto">475,00 €</strong>
                </div>
            </div>
        </div>


        <!-- ================= IVA ================= -->

        <div class="simulador iva">
            <div class="iva-topo">
                <div>

                    <p>Simule o apuramento de IVA do período.</p>
                </div>

                <select id="periodo">
                    <option>Maio 2026</option>
                    <option>Junho 2026</option>
                    <option>Julho 2026</option>
                    <option>Agosto 2026</option>
                </select>
            </div>

            <div class="iva-grid">

                <div class="iva-card">
                    <h3>▣ Dados do Período</h3>

                    <label>IVA Liquidado (Vendas e Prestações de Serviços)</label>
                    <input id="ivaLiquidado" type="number" value="933">

                    <label>IVA Dedutível (Compras e Gastos)</label>
                    <input id="ivaDedutivel" type="number" value="620">

                    <button class="btn-simular" onclick="calcularIVA()">
                        🧮 Simular
                    </button>
                </div>


                <div class="iva-card resultado-iva">

                    <h3>♙ Resultado da Simulação</h3>

                    <div class="iva-principal">
                        <span id="ivaTitulo">IVA a Pagar</span>
                        <strong id="ivaResultado">313,00 €</strong>
                        <small>IVA Liquidado - IVA Dedutível</small>
                    </div>

                    <div class="iva-valores">

                        <div>
                            <span>IVA Liquidado</span>
                            <strong id="resLiquidado">933,00 €</strong>
                        </div>

                        <div>
                            <span>IVA Dedutível</span>
                            <strong id="resDedutivel">620,00 €</strong>
                        </div>

                        <div>
                            <span>Diferença</span>
                            <strong id="resDiferenca">313,00 €</strong>
                        </div>

                    </div>
                </div>

            </div>


            <div class="aviso">
                ℹ️ Se o resultado for positivo, existe IVA a pagar ao Estado.
                <br>
                Se o resultado for negativo, existe IVA a recuperar do Estado.
            </div>


            <div class="calculo">

                <h3>Como é calculado?</h3>

                <div>
                    <span>IVA Liquidado</span>
                    <strong id="calcLiquidado">933,00 €</strong>

                    <b>−</b>

                    <span>IVA Dedutível</span>
                    <strong id="calcDedutivel">620,00 €</strong>

                    <b>=</b>

                    <span>IVA a Pagar / Recuperar</span>
                    <strong id="calcResultado">313,00 €</strong>
                </div>

                <small>ⓘ Taxas de IVA consideradas: 6%, 13% e 23%.</small>
            </div>

        </div>

    </section>
  </main>
</div>

<script src="assets/js/projecoes.js"></script>

<!-- Toggle do dropdown do utilizador na sidebar -->
<script>
  const userToggle = document.getElementById('userToggle');
  const userDropdown = document.getElementById('userDropdown');

  if (userToggle && userDropdown) {
    userToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
      userDropdown.classList.remove('show');
    });
  }
</script>
</body>
</html>
