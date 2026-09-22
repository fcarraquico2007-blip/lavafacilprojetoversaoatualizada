<?php
// agendar.php
// Página de agendamento de serviços.
// O cliente escolhe o serviço e o JavaScript (agendar.js) mostra
// os campos certos e calcula o preço.

// 1. Ligação à base de dados e configuração dos serviços
require_once 'conexao.php';
$config = require 'config_servicos.php';

// 2. Ir buscar os serviços à base de dados
try {
    $stmt = $pdo->query("SELECT cod_tiposervico, descricao FROM tipos_servicos ORDER BY cod_tiposervico");
    $todosServicos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar os serviços: " . htmlspecialchars($e->getMessage()));
}

// 3. Ficar só com os serviços que têm configuração (preços, campos a mostrar)
$servicos = [];     // serve para preencher a lista de escolha (select)
$servicosJs = [];   // vai para o JavaScript

foreach ($todosServicos as $s) {
    $id = (int) $s['cod_tiposervico'];

    if (isset($config[$id])) {
        $servicos[] = [
            'id'   => $id,
            'nome' => $s['descricao']
        ];

        $servicosJs[$id] = [
            'nome'                    => $s['descricao'],
            'mostrar_kg'              => $config[$id]['mostrar_kg'],
            'preco_kg'                => $config[$id]['preco_kg'],
            'preco_fixo'              => $config[$id]['preco_fixo'],
            'mostrar_extras'          => $config[$id]['mostrar_extras'],
            'mostrar_recolha_entrega' => $config[$id]['mostrar_recolha_entrega']
        ];
    }
}

// 4. Serviço escolhido no link (ex.: agendar.php?id=1)
$idInicial = 0;

if (isset($_GET['id'])) {
    $idInicial = (int) $_GET['id'];
}

// Se o número não for de nenhum serviço, fica sem nada escolhido
if (!isset($servicosJs[$idInicial])) {
    $idInicial = 0;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar - LavaFácil</title>
    <link rel="stylesheet" href="public/assets/css/lavagens.css">
</head>
<body>
<div class="container">

<!-- FORMULÁRIO -->
<section class="formulario">

    <h1 id="tituloServico">Agendar serviço</h1>

    <!-- Escolha do serviço (vem da base de dados) -->
    <div class="campo campo-seletor-servico">
        <label for="servicoSelecionado">Serviço</label>
        <select id="servicoSelecionado">
            <option value="">Escolhe um serviço...</option>
            <?php foreach ($servicos as $s): ?>
                <option value="<?php echo $s['id']; ?>" <?php if ($s['id'] === $idInicial) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($s['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Os campos abaixo estão sempre na página.
         O JavaScript mostra ou esconde cada um conforme o serviço escolhido. -->

    <div class="campo oculto" id="blocoKg">
        <label for="kg">Quantidade (Kg)</label>
        <input type="number" id="kg" min="1" max="30" step="0.5" placeholder="Ex: 5">
        <small id="kgAviso" class="aviso"></small>
    </div>

    <div class="campo oculto" id="blocoTipoRoupa">
        <label for="tipoRoupa">Tipo de roupa</label>
        <select id="tipoRoupa">
            <option value="Normal">Normal</option>
            <option value="Delicada">Delicada</option>
            <option value="Cama">Roupa de cama</option>
            <option value="Toalhas">Toalhas</option>
        </select>
    </div>

    <div class="campo oculto" id="blocoExtras">
        <label for="extras">Extras</label>
        <select id="extras">
            <option value="Nenhum">Nenhum</option>
            <option value="Perfume">Perfume especial (+1€)</option>
            <option value="Dobrar">Dobrar roupa (+1€)</option>
            <option value="Urgente">Serviço urgente (+3€)</option>
        </select>
    </div>

    <div class="campo oculto" id="blocoRecolha">
        <label for="recolha">Recolha</label>
        <select id="recolha">
            <option value="Loja">Entregar na loja</option>
            <option value="Casa">Recolha em casa</option>
        </select>
    </div>

    <div class="campo oculto" id="blocoEntrega">
        <label for="entrega">Entrega</label>
        <select id="entrega">
            <option value="Loja">Levantar na loja</option>
            <option value="Casa">Entrega em casa</option>
        </select>
    </div>

    <div class="campo oculto" id="blocoLocalidade">
        <label for="localidade">Localidade</label>
        <select id="localidade">
            <option value="Montemor-o-Novo" data-km="0">Montemor-o-Novo</option>
            <option value="São Cristóvão" data-km="10">São Cristóvão - 10 Km</option>
            <option value="Arraiolos" data-km="10">Arraiolos - 10 Km</option>
            <option value="Santiago do Escoural" data-km="18">Santiago do Escoural - 18 Km</option>
            <option value="Silveiras" data-km="15">Silveiras - 15 Km</option>
            <option value="Lavre" data-km="25">Lavre - 25 Km</option>
        </select>
    </div>

    <div class="campo oculto" id="blocoData">
        <label for="dataServico">Data do serviço</label>
        <input type="date" id="dataServico">
    </div>

    <div class="campo oculto" id="blocoHora">
        <label for="horaServico">Hora</label>
        <select id="horaServico">
            <option value="08:00">08:00</option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
            <option value="17:00">17:00</option>
        </select>
    </div>

    <div class="preco oculto" id="blocoPreco">
        <h3>Total estimado: <span id="precoTotal">0.00€</span></h3>
        <p>O valor final poderá ser ajustado após pesagem.</p>
    </div>

    <button type="button" class="btn btn-principal oculto" id="btnContinuar" onclick="mostrarResumo()">Continuar</button>

    <p id="avisoSemServico" class="aviso" style="margin-top:14px;">Escolhe um serviço acima para começares o agendamento.</p>

</section>

<!-- RESUMO DO PEDIDO -->
<section id="resumo" class="resumo">

    <h2>Resumo do Pedido</h2>

    <table>
        <tr><th>Serviço</th><td id="rServico"></td></tr>
        <tr><th>Data</th><td id="rData"></td></tr>
        <tr><th>Hora</th><td id="rHora"></td></tr>
        <tr id="linhaRKg"><th>Peso</th><td id="rKg"></td></tr>
        <tr id="linhaRTipo"><th>Tipo de roupa</th><td id="rTipo"></td></tr>
        <tr id="linhaRExtras"><th>Extras</th><td id="rExtras"></td></tr>
        <tr id="linhaRRecolha"><th>Recolha</th><td id="rRecolha"></td></tr>
        <tr id="linhaREntrega"><th>Entrega</th><td id="rEntrega"></td></tr>
        <tr><th>Localidade</th><td id="rLocalidade"></td></tr>
        <tr><th>Preço estimado</th><td id="rPreco"></td></tr>
    </table>

    <p class="aviso-final">O valor final poderá ser ajustado após a pesagem da roupa.</p>

    <p id="erroPedido" style="color:red; display:none;"></p>

    <div class="botoes">
        <button type="button" class="btn btn-secundario" onclick="irParaPagamentoLoja()">Pagar na loja</button>
        <button type="button" class="btn btn-principal" onclick="irParaPagamentoOnline()">Pagar Online</button>
    </div>

</section>

</div>

<!-- Dados que o PHP passa ao JavaScript -->
<script>
    // Lista dos serviços com os preços e os campos a mostrar
    const SERVICOS = <?php echo json_encode($servicosJs, JSON_UNESCAPED_UNICODE); ?>;

    // Serviço que vem escolhido no link (0 = nenhum)
    const ID_INICIAL = <?php echo $idInicial; ?>;
</script>
<script src="assets/js/agendar.js"></script>
</body>
</html>