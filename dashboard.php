
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LavaFácil – Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
 <?php include __DIR__ . '/layoutfrancisco/sidebar.php'; ?>


    <main class="content">

        <header class="topbar">
            <div>
                <h2>Bem-vindo, administrador! 👋</h2>
                <p>Aqui está o resumo geral do desempenho da LavaFácil.</p>
                <small class="text-muted" id="dataAtual"></small>
            </div>
            <button class="btn btn-light">
                <i class="fa fa-bell"></i>
            </button>
        </header>

        <section class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small>Faturação (Mês)</small>
                        <h3>7.215.20 €</h3>
                        <span class="text-success">+ 18,70% face a fevereiro</span>
                    </div>
                    <div class="icon blue"><i class="fa fa-chart-line"></i></div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small>Lucro Líquido (Mês)</small>
                        <h3>91.72 €</h3>
                        <span class="text-success"></span>
                    </div>
                    <div class="icon green"><i class="fa fa-euro-sign"></i></div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small>Serviços Realizados</small>
                        <h3>2058</h3>
                        <span class="text-success">+ 20,77% face ao mês de fevereiro </span>
                    </div>
                    <div class="icon purple"><i class="fa fa-calendar-check"></i></div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div>
                        <small>Clientes Ativos</small>
                        <h3>36</h3>

                    </div>
                    <div class="icon orange"><i class="fa fa-users"></i></div>
                </div>
            </div>
        </section>

        <section class="row g-4 mt-2">
            <div class="col-lg-8">
                <div class="chart-box">
                    <h5><i class="fa fa-chart-column text-primary"></i> Faturação vs Gastos (Mês)</h5>
                    <div class="chart-wrapper">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-box">
                    <h5><i class="fa fa-chart-pie text-success"></i> Distribuição de Serviços</h5>
                    <div class="chart-wrapper">
                        <canvas id="serviceChart"></canvas>
                    </div>
                    <h6 class="text-muted d-block mt-2">Total: 1 245 serviços</h6>
                </div>
            </div>
        </section>

        <section class="row g-4 mt-2">
            <div class="col-lg-6">
                <div class="chart-box">
                    <h5><i class="fa fa-chart-pie text-warning"></i> Gastos por Categoria (Mês)</h5>
                    <div class="chart-wrapper">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>
            </div>

     <div class="col-lg-6">
    <div class="chart-box">
        <h5><i class="fa fa-arrow-trend-up text-success"></i> Projeção de Faturação</h5>
        <div class="chart-wrapper">
            <canvas id="projectionChart"></canvas>
        </div>
        <p class="text-muted mt-3 mb-0">
            Total projetado para o próximo trimestre: <strong>18.357,80 €</strong>
        </p>
    </div>
</div>

        <section class="row g-4 mt-2">
            <div class="col-lg-12">
                <div class="table-box">
                    <h5>Agendamentos de Hoje</h5>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Serviço</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>08:00</td>
                                <td>Lurdes Pinguincha</td>
                                <td>Lavagem</td>
                                <td><span class="badge bg-success">Concluído</span></td>
                            </tr>
                            <tr>
                                <td>09:00</td>
                                <td>Gustavo Almeida</td>
                                <td>Engomadoria</td>
                                <td><span class="badge bg-primary">Em andamento</span></td>
                            </tr>
                            <tr>
                                <td>09:30</td>
                                <td>Lar o Pequenino</td>
                                <td>Pack Mensal Médio</td>
                                <td><span class="badge bg-warning text-dark">Agendado</span></td>
                            </tr>
                            <tr>
                                <td>10:00</td>
                                <td>Filipa Galinha</td>
                                <td>Pack Lavagem + Secagem + Ferro</td>
                                <td><span class="badge bg-warning text-dark">Agendado</span></td>
                            </tr>
                            <tr>
                                <td>10:15</td>
                                <td>Lara Silva</td>
                                <td>Lavagem + Secagem</td>
                                <td><span class="badge bg-warning text-dark">Agendado</span></td>
                            </tr>
                            <tr>
                                <td>11:30</td>
                                <td>Diogo Silva</td>
                                <td>Engomadoria</td>
                                <td><span class="badge bg-warning text-dark">Agendado</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

           
        </section>

        <section class="row g-4 mt-2">
            <div class="col-lg-4">
                <div class="table-box">
                    <h5>Análise Financeira</h5>
                    <p>Liquidez Geral <b class="float-end">1,45 (Boa)</b></p>
                    <p>Autonomia Financeira <b class="float-end">52,6% (Boa)</b></p>
                    <p>Endividamento <b class="float-end">47,4% (Moderado)</b></p>
                    <p>Rentabilidade <b class="float-end">18,7% (Boa)</b></p>
                </div>
            </div>

            

            <div class="col-lg-4">
                <div class="table-box">
                    <h5>Recursos Humanos</h5>
                    <p>Colaboradores <b class="float-end">12</b></p>
                    <p>Férias Pendentes <b class="float-end">2</b></p>
                   
                </div>
            </div>

            <div class="col-lg-4">
                <div class="table-box">
                    <h5>Entidades</h5>
                    <p>Clientes <b class="float-end">1 268</b></p>
                    <p>Fornecedores <b class="float-end">42</b></p>
                </div>
            </div>
        </section>

    </main>

    <script src="assets/js/dashboard.js"></script>
</body>

</html>