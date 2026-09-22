// =============================
// Faturação vs Gastos (Mês)
// =============================
new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
        labels: ['Janeiro', 'Fevereiro', 'Março'],
        datasets: [
            {
                label: 'Faturação (€)',
                data: [2669.80, 6078.30, 7215.20],
                backgroundColor: '#0d6efd',
                borderRadius: 6,
                barPercentage: 0.7,
                categoryPercentage: 0.6
            },
            {
                label: 'Gastos (€)',
                data: [11480.11, 6670.26, 7123.48],
                backgroundColor: '#22c55e',
                borderRadius: 6,
                barPercentage: 0.7,
                categoryPercentage: 0.6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { ticks: { font: { size: 16 } } },
            y: { ticks: { font: { size: 16 } } }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 14 } }
            }
        }
    }
});

// =============================
// Distribuição de Serviços
// =============================
new Chart(document.getElementById('serviceChart'), {
    type: 'doughnut',
    data: {
        labels: ['Lavagem','Secagem','Engomadoria','Entrega em casa','Recolha em casa','Outros (Packs)'],
        datasets: [{
            data: [980,1110,907,767,543,507],
            backgroundColor: ['#0d6efd','#22c55e','#f59e0b','#7c3aed','#ef4444','#a79999']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
        
    }
});

// =============================
// Gastos por Categoria
// =============================
new Chart(document.getElementById('expenseChart'), {
    type: 'pie',
    data: {
        labels: ['Salários','Produtos','Serviços Externos','Utilidades','Outros'],
        datasets: [{
            data: [35.4,28.1,15.8,10.5,10.2],
            backgroundColor: ['#0d6efd','#22c55e','#f59e0b','#7c3aed','#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});
// =============================
// Projeções de Faturação (+15%)
// =============================
new Chart(document.getElementById('projectionChart'), {
    type: 'line',
    data: {
        labels: ['Janeiro', 'Fevereiro', 'Março'],
        datasets: [
            {
                label: 'Real',
                data: [2669.80, 6078.30, 7215.20],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,.15)',
                tension: 0.3,
                fill: true,
                pointRadius: 4
            },
            {
                label: 'Projeção (+15%)',
                data: [3070.27, 6990.05, 8297.48],
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,.15)',
                borderDash: [6, 6],
                tension: 0.3,
                fill: true,
                pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
// =============================
// Toggle User Menu
// =============================
const toggle = document.getElementById("userToggle");
const menu = document.getElementById("userDropdown");

toggle.addEventListener("click", () => {
    menu.classList.toggle("show");
});

document.addEventListener("click", (e) => {
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove("show");
    }
});
