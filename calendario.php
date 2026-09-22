
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
  <title>LavaFácil - Agendamentos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="public/assets/css/dashboard.css">
  <link rel="stylesheet" href="public/assets/css/calendario.css">

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
  </style>
</head>
<body>

<?php include __DIR__ . '/layoutfrancisco/sidebar.php'; ?>

<main class="content">

  <?php
    $tituloPagina    = 'Agendamentos';
    $subtituloPagina = 'Gerir e visualizar todos os agendamentos da empresa.';
    include __DIR__ . '/layoutfrancisco/navbar.php';
  ?>

  <section class="calendar-card">
    <div class="toolbar">
      <div class="view-switch">
        <button class="active" id="calendarView"><i class="bi bi-calendar3"></i> Calendário</button>
        <button id="listView"><i class="bi bi-list-ul"></i> Lista</button>
      </div>

      <div class="month-controls">
        <button id="prevMonth" class="square-btn"><i class="bi bi-chevron-left"></i></button>
        <button id="nextMonth" class="square-btn"><i class="bi bi-chevron-right"></i></button>
        <strong id="monthYear"></strong>
        <button id="todayBtn" class="today-btn">Hoje</button>
      </div>

      <div class="toolbar-actions">
        <button class="new-btn" id="newBtn"><i class="bi bi-plus-lg"></i> Novo Agendamento</button>
        <button class="filter-btn" id="filterBtn"><i class="bi bi-funnel"></i> Filtros</button>
      </div>
    </div>

    <div class="workspace">
      <div class="calendar-area">
        <div class="weekdays">
          <div>Seg</div><div>Ter</div><div>Qua</div><div>Qui</div><div>Sex</div><div>Sáb</div><div>Dom</div>
        </div>
        <div id="calendar" class="calendar-grid"></div>

        <div id="listContainer" class="list-container hidden"></div>
      </div>

      <aside class="right-panel">
        <div class="panel-card">
          <div class="panel-title">Navegar por mês</div>
          <div class="mini-head">
            <button id="miniPrev"><i class="bi bi-chevron-left"></i></button>
            <strong id="miniMonth"></strong>
            <button id="miniNext"><i class="bi bi-chevron-right"></i></button>
          </div>
          <div class="mini-week"><span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sáb</span><span>Dom</span></div>
          <div id="miniCalendar" class="mini-calendar"></div>
        </div>

        <div class="panel-card">
          <div class="panel-title">Filtros Rápidos</div>
          <select id="serviceFilter"><option value="">Todos os Serviços</option><option>Lavagem</option><option>Lavagem + Secagem</option><option>Engomadoria</option><option>Recolha</option></select>
          <select id="statusFilter"><option value="">Todos os Estados</option><option value="agendado">Agendado</option><option value="preparacao">Em preparação</option><option value="concluido">Concluído</option><option value="cancelado">Cancelado</option></select>
          <select id="workerFilter"><option value="">Todos os Colaboradores</option><option>João</option><option>Maria</option></select>
        </div>

        <div class="panel-card">
          <div class="panel-title">Ajustar peso/preço</div>
          <button class="adjust weight" id="weightBtn"><i class="bi bi-speedometer2"></i> Ajustar Peso</button>
          <button class="adjust price" id="priceBtn"><i class="bi bi-currency-euro"></i> Ajustar Preço</button>
        </div>

        <div class="panel-card summary">
          <div class="panel-title">Resumo do Mês</div>
          <div class="summary-grid">
            <div><strong id="totalCount">0</strong><small>Total Agendamentos</small></div>
            <div><strong id="doneCount">0</strong><small>Concluídos</small></div>
            <div><strong id="prepCount">0</strong><small>Em preparação</small></div>
            <div><strong id="cancelCount">0</strong><small>Cancelados</small></div>
          </div>
          <div class="total-value">Valor total <strong id="totalValue">0,00 €</strong></div>
        </div>
      </aside>
    </div>
  </section>
</main>

<div class="modal fade" id="appointmentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Novo Agendamento</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="appointmentForm">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6"><label>Cliente</label><input id="client" class="form-control" required></div>
            <div class="col-md-6"><label>Telefone</label><input id="phone" class="form-control"></div>
            <div class="col-md-6"><label>Data</label><input id="date" type="date" class="form-control" required></div>
            <div class="col-md-6"><label>Hora</label><input id="time" type="time" class="form-control" required></div>
            <div class="col-md-6"><label>Serviço</label><select id="service" class="form-select"><option>Lavagem</option><option>Lavagem + Secagem</option><option>Engomadoria</option><option>Recolha</option></select></div>
            <div class="col-md-6"><label>Colaborador</label><select id="worker" class="form-select"><option>João</option><option>Maria</option></select></div>
            <div class="col-md-6"><label>Peso previsto (kg)</label><input id="weight" type="number" min="0" step=".1" class="form-control" value="5"></div>
            <div class="col-md-6"><label>Preço (€)</label><input id="price" type="number" min="0" step=".01" class="form-control" value="10"></div>
            <div class="col-12"><label>Observações</label><textarea id="notes" class="form-control" rows="2"></textarea></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-primary">Guardar</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Detalhes da marcação</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body" id="details"></div>
      <div class="modal-footer">
        <button class="btn btn-outline-primary" id="prepBtn">Aceitar / Preparação</button>
        <button class="btn btn-success" id="doneBtn">Serviço Concluído</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/calendario.js"></script>

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