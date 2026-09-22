<?php
require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT valor_servico FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);
$valor = $stmt->fetchColumn();

if ($valor === false) {
    die('Pedido não encontrado. <a href="servicos.php">Voltar aos serviços</a>');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Métodos de Pagamento - LavaFácil</title>
    <link rel="stylesheet" href="css/pagamento.css">
    
    <!-- Mantenha esta linha exatamente no topo do <head>, antes de fechar a tag -->
    <script src="https://stripe.com"></script>
</head>

<div class="container">
    <h1>Métodos de Pagamento</h1>
    <p class="valor">Valor a pagar: <strong id="valorPagar"><?php echo number_format($valor, 2, ',', '.'); ?>€</strong></p>

    <!-- Botões de seleção originais -->
     <!-- Procure os botões e substitua exatamente por estes: -->
    <div class="metodos">
        <!-- Botão do MBWay corrigido para chamar 'mostrarMetodo' -->
        <button class="metodo" onclick="mostrarMetodo('mbway')">
            <img src="img/Logo_MBWay.svg.webp" width="80px" class="icon">
        </button>
        
        <!-- Botão do Cartão corrigido para chamar 'mostrarMetodo' -->
        <button class="metodo" onclick="mostrarMetodo('cartao')">
            <img src="img/logoscartoes.png" width="120px" class="icon">
        </button>
    </div>

    <!-- Container MBWay Local -->
    <div id="formMBWay" class="form-pagamento" style="display: none; margin-top: 20px;">
        <h2>Pagamento MBWay</h2>
        <label>Número de telemóvel</label>
        <input type="text" id="mbwayNumero" placeholder="Ex: 912345678" style="width: 100%; padding: 10px; margin: 10px 0;">
        <button class="btn" onclick="pagarMBWay()" style="width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Confirmar MBWay</button>
    </div>

    <!-- Container Cartão Embutido (Stripe Elements) -->
    <div id="formCartao" class="form-pagamento" style="display: none; margin-top: 20px;">
        <h2>Pagamento com Cartão Direto</h2>
        <form id="payment-form">
            <!-- Os campos seguros do cartão vão aparecer magicamente dentro desta div -->
            <div id="card-element" style="padding: 12px; border: 1px solid #ccc; border-radius: 4px; background: white; margin: 15px 0;"></div>
            
            <!-- Mensagens de erro de validação do cartão -->
            <div id="card-errors" role="alert" style="color: red; margin-bottom: 10px;"></div>

            <button id="submit-button" class="btn" style="width: 100%; padding: 12px; background: #635bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Confirmar Pagamento Seguro
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Captura dinâmica do ID do Pedido vindo do PHP
    const ID_PEDIDO = <?php echo (int)$id; ?>;
    
    // Variáveis globais para controlo do formulário
    let stripe, elements, cardElement;

    // Função que inicializa os campos de forma segura após a biblioteca carregar
    function inicializarStripe() {
        if (typeof Stripe === 'undefined') {
            console.log('A aguardar carregamento do script da Stripe...');
            setTimeout(inicializarStripe, 200); // Tenta novamente em 200ms
            return;
        }

        // 2. Inicializar a Stripe com a sua Chave Pública real (Validada do seu painel)
        stripe = Stripe('pk_test_51UBAyaL3XJ7ajDGDCUiCgnsKl2Qf7hQOaPJ9MjiQnnj8XmgR6Z7s0FGr0ajjKfJejpf3orCuEEoVHbjzQwl1G9dp00z4IIhOLp');
        elements = stripe.elements();

        // 3. Criar o elemento do cartão e montá-lo na página
        cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    fontFamily: 'sans-serif',
                    '::placeholder': { color: '#aab7c4' }
                }
            }
        });
        
        // Monta o campo dentro da div reservada
        cardElement.mount('#card-element');
        console.log('Campos seguros da Stripe montados com sucesso!');
    }

    // Executa a inicialização assim que a estrutura da página estiver pronta
    document.addEventListener("DOMContentLoaded", inicializarStripe);

    // Função para alternar a exibição visual das caixas (MBWay / Cartão)
    function mostrarMetodo(tipo) {
        document.getElementById('formMBWay').style.display = (tipo === 'mbway') ? 'block' : 'none';
        document.getElementById('formCartao').style.display = (tipo === 'cartao') ? 'block' : 'none';
    }

    // 4. Processar o clique no botão roxo de submissão do pagamento
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        const submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;
        submitButton.textContent = "A processar pagamento seguro...";

        try {
            // Pede a chave de intenção secreta (Client Secret) ao ficheiro PHP
            const resposta = await fetch('criar_intencao_pagamento.php?id=' + ID_PEDIDO);
            const dadosSessao = await resposta.json();

            if (dadosSessao.error) {
                document.getElementById('card-errors').textContent = dadosSessao.error;
                submitButton.disabled = false;
                submitButton.textContent = "Confirmar Pagamento Seguro";
                return;
            }

            // Confirma o pagamento diretamente na página usando a API da Stripe
            const resultado = await stripe.confirmCardPayment(dadosSessao.client_secret, {
                payment_method: {
                    card: cardElement
                }
            });

            if (resultado.error) {
                document.getElementById('card-errors').textContent = resultado.error.message;
                submitButton.disabled = false;
                submitButton.textContent = "Confirmar Pagamento Seguro";
            } else {
                if (resultado.paymentIntent.status === 'succeeded') {
                    // Pagamento aceite! Redireciona o cliente para o seu sucesso local
                    window.location.href = 'confirmacao_pagamento.php?status=sucesso&id=' + ID_PEDIDO;
                }
            }
        } catch (erroGeral) {
            document.getElementById('card-errors').textContent = "Erro de comunicação com o servidor.";
            submitButton.disabled = false;
            submitButton.textContent = "Confirmar Pagamento Seguro";
        }
    });
</script>
</body>
</html>