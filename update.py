import re

with open('index.html', 'r', encoding='utf-8') as f:
    content = f.read()

# Modify tailwind config
content = content.replace(
    '''                    colors: {
                        nature: {
                            DEFAULT: '#2D6A4F',
                            light: '#40916C',
                            dark: '#1B4332',
                        }
                    }''',
    '''                    colors: {
                        nature: {
                            DEFAULT: '#2D6A4F',
                            light: '#40916C',
                            dark: '#1B4332',
                        }
                    },
                    animation: {
                        'scan': 'scan 3s linear infinite',
                    },
                    keyframes: {
                        scan: {
                            '0%': { transform: 'translateY(-100%)' },
                            '100%': { transform: 'translateY(100%)' },
                        }
                    }'''
)

# Replace cards section
cards_regex = re.compile(r'<!-- Stats Cards -->.*?<!-- Main Section: Chart & Controls Grid -->', re.DOTALL)
new_cards = '''<!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                    <!-- Temp Card -->
                    <div onclick="changeChart('temp')" class="cursor-pointer bg-white rounded-xl shadow-sm p-4 border-2 border-nature transition-all duration-300 ring-2 ring-nature ring-opacity-50 hover:shadow-md" id="card-temp">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Température Air</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1"><span id="val-temp" class="sensor-value">30.5</span> <span class="text-lg text-gray-400">°C</span></p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                                <i class="fa-solid fa-temperature-half"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Humidité Air Card -->
                    <div onclick="changeChart('humAir')" class="cursor-pointer bg-white rounded-xl shadow-sm p-4 border-2 border-transparent hover:border-nature transition-all duration-300 hover:shadow-md" id="card-humAir">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Humidité Air</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1"><span id="val-hum-air" class="sensor-value">72</span> <span class="text-lg text-gray-400">%</span></p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-500">
                                <i class="fa-solid fa-cloud-rain"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Humidité Sol Card -->
                    <div onclick="changeChart('humSol')" class="cursor-pointer bg-white rounded-xl shadow-sm p-4 border-2 border-transparent hover:border-nature transition-all duration-300 hover:shadow-md" id="card-humSol">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Humidité Sol</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1"><span id="val-hum" class="sensor-value">68</span> <span class="text-lg text-gray-400">%</span></p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Luminosité Card -->
                    <div onclick="changeChart('lum')" class="cursor-pointer bg-white rounded-xl shadow-sm p-4 border-2 border-transparent hover:border-nature transition-all duration-300 hover:shadow-md" id="card-lum">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Luminosité</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1"><span id="val-lum" class="sensor-value">8500</span> <span class="text-lg text-gray-400">Lux</span></p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                                <i class="fa-regular fa-sun"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Risque fongique Card -->
                    <div onclick="changeChart('risque')" class="cursor-pointer bg-white rounded-xl shadow-sm p-4 border-2 border-transparent hover:border-nature transition-all duration-300 hover:shadow-md" id="card-risque">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Risque Fongique</p>
                                <p class="text-3xl font-bold mt-1 text-red-600"><span id="val-risque" class="sensor-value">85</span><span class="text-lg text-gray-400">/100</span></p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                                <i class="fa-solid fa-biohazard"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Section: Chart & Controls Grid -->
'''
content = cards_regex.sub(new_cards, content)

# Replace AI insights with the Robot vision section and modify Left Column
old_chart = '''<!-- Chart Section -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-800">Évolution du Taux de Fer</h2>
                                <p class="text-sm text-gray-500">Historique des 12 dernières heures</p>
                            </div>
                            <button class="text-gray-400 hover:text-nature transition-colors p-2"><i class="fa-solid fa-download"></i></button>
                        </div>
                        <div class="relative h-72 w-full">
                            <canvas id="ironChart"></canvas>
                        </div>
                    </div>'''
new_chart = '''<!-- Left Column Section (Chart + Robot) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Chart Section -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 id="chart-title" class="text-lg font-bold text-gray-800">Évolution : Température Air (°C)</h2>
                                    <p class="text-sm text-gray-500">Historique des 12 dernières heures</p>
                                </div>
                                <button class="text-gray-400 hover:text-nature transition-colors p-2"><i class="fa-solid fa-download"></i></button>
                            </div>
                            <div class="relative h-72 w-full">
                                <canvas id="mainChart"></canvas>
                            </div>
                        </div>

                        <!-- Robot Section -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 relative">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                <h2 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-robot mr-2 text-nature"></i>Analyse Visuelle par Robot</h2>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded"><i class="fa-solid fa-circle-check mr-1"></i>En Ligne</span>
                            </div>
                            <div class="relative h-64 bg-gray-900 w-full group">
                                <img src="https://images.unsplash.com/photo-1592079927431-3f8cd5b306b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Serre de tomates" class="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition-opacity">
                                
                                <!-- Scan Line Overlay Simulation -->
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-green-400 to-transparent opacity-20 h-full w-full animate-scan pointer-events-none"></div>
                                
                                <!-- Detection Overlay -->
                                <div class="absolute bottom-4 left-4 bg-black/60 backdrop-blur-sm border border-gray-700 text-white p-3 rounded-lg flex flex-col space-y-1">
                                    <div class="text-sm font-medium"><i class="fa-solid fa-magnifying-glass-chart text-green-400 mr-2"></i>Analyse de rendement : <span class="font-bold text-green-400">OK (Optimal)</span></div>
                                    <div class="text-sm font-medium"><i class="fa-solid fa-shield-virus text-green-400 mr-2"></i>Détection de maladie : <span class="font-bold">AUCUNE</span></div>
                                </div>
                                
                                <div class="absolute top-4 right-4 text-xs font-mono text-green-400 bg-black/50 px-2 py-1 rounded border border-green-900/50">
                                    REC <span class="animate-pulse text-red-500 ml-1">●</span>
                                </div>
                            </div>
                        </div>
                    </div>'''
content = content.replace(old_chart, new_chart)

old_ai_insight = r'''<!-- AI Insights -->
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl shadow-sm p-6 border border-indigo-100 relative overflow-hidden group">
                            <!-- Background Icon decoration -->
                            <div class="absolute -top-4 -right-4 p-4 opacity-5 group-hover:opacity-10 transition-opacity duration-500 transform group-hover:scale-110">
                                <i class="fa-solid fa-microchip text-8xl text-indigo-900"></i>
                            </div>
                            
                            <div class="flex items-center mb-4 relative z-10">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3 shadow-sm">
                                    <i class="fa-solid fa-sparkles text-sm animate-pulse"></i>
                                </div>
                                <h2 class="text-lg font-bold text-indigo-900">Analyste Virtuel</h2>
                            </div>
                            
                            <div class="bg-white bg-opacity-70 rounded-lg p-4 backdrop-blur-sm border border-indigo-50 relative z-10 shadow-sm">
                                <p class="text-sm text-indigo-800 font-medium leading-relaxed italic">
                                    "L'IA prévoit une baisse du fer dans 2 heures suite à la hausse de la luminosité observée sur le secteur Agadir."
                                </p>
                            </div>
                            
                            <div class="mt-4 flex items-center text-xs text-indigo-600 font-bold relative z-10">
                                <span class="flex h-2.5 w-2.5 rounded-full bg-indigo-500 mr-2 animate-ping relative inline-flex"></span>
                                <span class="absolute inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500 mr-2"></span>
                                <span class="ml-4">Analyse prédictive active</span>
                            </div>
                        </div>'''
content = content.replace(old_ai_insight, '')

# Replace script part
js_start = content.index('// --- 1. Simulation de données "Vivantes" ---')
js_end = content.rfind('</script>')
old_js = content[js_start:js_end]

new_js = '''// --- 1. Simulation de données "Vivantes" ---
        const tempEl = document.getElementById('val-temp');
        const humEl = document.getElementById('val-hum');
        const lumEl = document.getElementById('val-lum');
        const humAirEl = document.getElementById('val-hum-air');
        const risqueEl = document.getElementById('val-risque');
        const alertsContainer = document.getElementById('alerts-container');

        let baseTemp = 30.5; // Démo alerte
        let baseHum = 68;
        let baseLum = 8500;
        let baseHumAir = 72; // Démo alerte

        function updateSensors() {
            const newTemp = baseTemp + (Math.random() * 0.4 - 0.2);
            const newHum = Math.max(0, Math.min(100, baseHum + Math.floor(Math.random() * 3 - 1)));
            const newHumAir = Math.max(0, Math.min(100, baseHumAir + Math.floor(Math.random() * 3 - 1)));
            const newLum = baseLum + Math.floor(Math.random() * 200 - 100);

            if (tempEl) tempEl.textContent = newTemp.toFixed(1);
            if (humEl) humEl.textContent = newHum;
            if (lumEl) lumEl.textContent = newLum;
            if (humAirEl) humAirEl.textContent = newHumAir;

            let activeAlerts = '';
            let currentRisque = 40;

            if (newHumAir > 70) {
                currentRisque = 85;
                activeAlerts += `<div class="bg-red-50 border-l-4 border-red-500 p-3 rounded shadow-sm transition-all">
                    <p class="text-sm text-red-800 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Humidité élevée détectée -> Risque de Mildiou élevé !</p>
                </div>`;
            } else if (newHumAir > 60) {
                currentRisque = 60;
            }

            if (newTemp > 30) {
                activeAlerts += `<div class="bg-orange-50 border-l-4 border-orange-500 p-3 rounded shadow-sm transition-all">
                    <p class="text-sm text-orange-800 font-semibold"><i class="fa-solid fa-fire mr-2"></i>Température > 30°C -> risque de maladie</p>
                </div>`;
            }

            if (risqueEl) {
                risqueEl.textContent = currentRisque;
                if (currentRisque >= 80) {
                    risqueEl.parentElement.className = 'text-3xl font-bold mt-1 text-red-600';
                } else if (currentRisque >= 60) {
                    risqueEl.parentElement.className = 'text-3xl font-bold mt-1 text-orange-500';
                } else {
                    risqueEl.parentElement.className = 'text-3xl font-bold mt-1 text-green-500';
                }
            }

            if (alertsContainer) {
                if (activeAlerts === '') {
                    alertsContainer.innerHTML = '<p class="text-sm text-gray-500 italic">Aucune alerte pour le moment.</p>';
                } else {
                    alertsContainer.innerHTML = activeAlerts;
                }
            }

            baseTemp = newTemp;
            baseHum = newHum;
            baseHumAir = newHumAir;
            baseLum = newLum;

            // Mettre à jour les données du graphique
            if(window.chartData && window.mainChart) {
                window.chartData['temp'].data[6] = parseFloat(newTemp.toFixed(1));
                window.chartData['humAir'].data[6] = newHumAir;
                window.chartData['humSol'].data[6] = newHum;
                window.chartData['lum'].data[6] = newLum;
                window.chartData['risque'].data[6] = currentRisque;
                window.mainChart.update();
            }
        }

        updateSensors();
        setInterval(updateSensors, 5000);

        // --- 2. Chart.js : Dynamic Area Chart ---
        const ctx = document.getElementById('mainChart').getContext('2d');
        
        window.chartData = {
            temp: { label: 'Température Air (°C)', data: [28.2, 28.5, 29.1, 29.8, 30.2, 30.4, baseTemp], color: '#f97316', bg: 'rgba(249, 115, 22, 0.4)', min: 15, max: 45 },
            humAir: { label: 'Humidité Air (%)', data: [60, 62, 65, 68, 70, 71, baseHumAir], color: '#06b6d4', bg: 'rgba(6, 182, 212, 0.4)', min: 0, max: 100 },
            humSol: { label: 'Humidité Sol (%)', data: [63, 64, 65, 66, 67, 68, baseHum], color: '#3b82f6', bg: 'rgba(59, 130, 246, 0.4)', min: 0, max: 100 },
            lum: { label: 'Luminosité (Lux)', data: [7500, 7800, 8000, 8200, 8400, 8450, baseLum], color: '#eab308', bg: 'rgba(234, 179, 8, 0.4)', min: 0, max: 15000 },
            risque: { label: 'Risque Fongique (Indice)', data: [40, 45, 55, 65, 75, 80, 85], color: '#ef4444', bg: 'rgba(239, 68, 68, 0.4)', min: 0, max: 100 }
        };

        let currentActiveChart = 'temp';

        function getGradient(colorStr) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, colorStr);
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0.0)');
            return gradient;
        }

        const labels = ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00', 'Maintenant'];

        window.mainChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: window.chartData[currentActiveChart].label,
                    data: window.chartData[currentActiveChart].data,
                    borderColor: window.chartData[currentActiveChart].color,
                    backgroundColor: getGradient(window.chartData[currentActiveChart].bg),
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: window.chartData[currentActiveChart].color,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: 'start',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937', bodyColor: '#4b5563', borderColor: '#e5e7eb', borderWidth: 1, padding: 12, displayColors: false,
                        titleFont: { family: "'Inter', sans-serif", size: 13 }, bodyFont: { family: "'Inter', sans-serif", size: 14, weight: 'bold' },
                        callbacks: {
                            label: function(context) { return context.parsed.y + ''; }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false }, ticks: { color: '#6b7280', font: { family: "'Inter', sans-serif" } } },
                    y: { grid: { color: '#f3f4f6', drawBorder: false }, ticks: { color: '#6b7280', font: { family: "'Inter', sans-serif" }, stepSize: 5 }, min: window.chartData[currentActiveChart].min, max: window.chartData[currentActiveChart].max }
                },
                interaction: { mode: 'index', intersect: false }
            }
        });

        // Fonction globale de clic sur les cartes pour changer le graphique
        window.changeChart = function(key) {
            currentActiveChart = key;
            
            // Mise à jour visuelle des cartes (enlever highlight)
            document.querySelectorAll('[id^="card-"]').forEach(el => {
                el.classList.remove('border-nature', 'shadow-md', 'ring-2', 'ring-nature', 'ring-opacity-50');
                el.classList.add('border-transparent');
            });
            // highlight active
            const activeCard = document.getElementById('card-' + key);
            activeCard.classList.remove('border-transparent');
            activeCard.classList.add('border-nature', 'shadow-md', 'ring-2', 'ring-nature', 'ring-opacity-50');

            // Mise à jour Titre du Graphe
            document.getElementById('chart-title').textContent = 'Évolution : ' + window.chartData[key].label;

            // Mise à jour Données Graphe
            window.mainChart.data.datasets[0].label = window.chartData[key].label;
            window.mainChart.data.datasets[0].data = window.chartData[key].data;
            window.mainChart.data.datasets[0].borderColor = window.chartData[key].color;
            window.mainChart.data.datasets[0].backgroundColor = getGradient(window.chartData[key].bg);
            window.mainChart.data.datasets[0].pointBorderColor = window.chartData[key].color;
            window.mainChart.options.scales.y.min = window.chartData[key].min;
            window.mainChart.options.scales.y.max = window.chartData[key].max;
            
            window.mainChart.update();
        };

        window.onload = function() {
            window.changeChart('temp');
        }

        // --- 3. Gestion du bouton d'action et Notification ---
        const btnPump = document.getElementById('btn-pump');
        const notification = document.getElementById('notification');
        const iaToggle = document.getElementById('ia-toggle');
        
        btnPump.addEventListener('click', () => {
            if(iaToggle.checked) {
                iaToggle.checked = false;
            }

            btnPump.disabled = true;
            btnPump.classList.add('opacity-90', 'cursor-wait');
            btnPump.classList.remove('hover:bg-nature-light');
            btnPump.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Initialisation API...';

            notification.classList.add('show');
            
            setTimeout(() => {
                btnPump.innerHTML = '<i class="fa-solid fa-droplet fa-bounce mr-2"></i> Distribution...';
                
                setTimeout(() => {
                    btnPump.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Injection réussie';
                    btnPump.classList.replace('bg-nature', 'bg-green-600');
                    notification.innerHTML = '<i class="fa-solid fa-check-circle mr-3"></i> Niveau ajusté avec succès !';
                    
                    // Boost humidite sol
                    baseHum = Math.min(100, baseHum + 15);
                    if(humEl) humEl.textContent = baseHum;
                    window.chartData['humSol'].data[6] = baseHum;
                    if(currentActiveChart === 'humSol') window.mainChart.update();

                    setTimeout(() => {
                        notification.classList.remove('show');
                        
                        setTimeout(() => {
                            btnPump.disabled = false;
                            btnPump.classList.remove('opacity-90', 'cursor-wait');
                            btnPump.classList.add('hover:bg-nature-light');
                            btnPump.classList.replace('bg-green-600', 'bg-nature');
                            btnPump.innerHTML = '<i class="fa-solid fa-power-off mr-2 group-hover:scale-110 transition-transform"></i> Actionner la pompe';
                            
                            setTimeout(() => {
                                notification.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-3"></i> <span class="font-medium">Distribution en cours...</span>';
                            }, 500);
                        }, 500);
                    }, 2500);

                }, 2000); 
            }, 800); 
        });
'''

content = content.replace(old_js, new_js)

with open('index.html', 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated successfully')
