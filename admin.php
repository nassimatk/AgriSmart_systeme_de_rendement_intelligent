<?php
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$stats_query1 = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='user'");
$users_count = $stats_query1->fetch_assoc()['count'];

$stats_query2 = $conn->query("SELECT COUNT(DISTINCT farm_name) as count FROM users WHERE role='user'");
$farms_count = $stats_query2->fetch_assoc()['count'];

$alerts_count = rand(1, 5); // Simulate active alerts

$users = $conn->query("SELECT * FROM users WHERE role='user' ORDER BY reg_date DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - AgriSmart Souss-Massa</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        nature: {
                            DEFAULT: '#2D6A4F',
                            light: '#40916C',
                            dark: '#1B4332',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800">

    <!-- Sidebar Admin -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-gray-800 bg-gray-950">
            <i class="fa-solid fa-shield-halved text-nature-light text-2xl mr-3"></i>
            <span class="text-xl font-bold tracking-wider">AgriAdmin</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <i class="fa-solid fa-chart-pie w-6"></i>
                <span class="font-medium">Vue d'ensemble</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 bg-nature text-white rounded-lg shadow-sm transition-colors">
                <i class="fa-solid fa-users w-6"></i>
                <span class="font-medium">Gestion Utilisateurs</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <i class="fa-solid fa-tractor w-6"></i>
                <span class="font-medium">Exploitations</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                <i class="fa-solid fa-server w-6"></i>
                <span class="font-medium">État du Système</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800 text-xs text-gray-500 text-center">
            &copy; 2026 Admin - Souss-Massa
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 lg:px-10 z-10 w-full">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-800">Gestion des Agriculteurs</h1>
                <span class="ml-4 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full flex items-center shadow-sm">
                    Mode Administrateur
                </span>
            </div>
            <div class="flex items-center space-x-6">
                <div class="relative group">
                    <input type="text" class="pl-10 pr-4 py-2 bg-gray-100 border-none rounded-lg text-sm focus:ring-2 focus:ring-nature focus:bg-white outline-none w-64 transition-all" placeholder="Rechercher un utilisateur...">
                    <i class="fa-solid fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
                <!-- Bouton déconnexion -->
                <a href="logout.php" class="h-10 w-10 border-2 border-gray-200 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 font-bold shadow-sm hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors" title="Quitter le mode admin">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto w-full p-6 lg:p-10">
            
            <div class="max-w-7xl mx-auto space-y-6">
                
                <!-- Statistiques Rapides Admin -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
                        <div class="h-14 w-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mr-4">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Utilisateurs Actifs</p>
                            <p class="text-2xl font-bold text-gray-800"><?= $users_count ?></p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
                        <div class="h-14 w-14 rounded-full bg-green-50 flex items-center justify-center text-green-500 mr-4">
                            <i class="fa-solid fa-tractor text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Exploitations Connectées</p>
                            <p class="text-2xl font-bold text-gray-800"><?= $farms_count ?></p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
                        <div class="h-14 w-14 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 mr-4">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alertes Capteurs</p>
                            <p class="text-2xl font-bold text-gray-800"><?= $alerts_count ?></p>
                            <p class="text-xs text-orange-600 font-medium">Nécessite attention</p>
                        </div>
                    </div>
                </div>

                <!-- Tableau des Utilisateurs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-800">Liste des Utilisateurs</h2>
                        <button class="bg-nature hover:bg-nature-light text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i>
                            Ajouter un agriculteur
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                                    <th class="px-6 py-4 font-semibold">Agriculteur</th>
                                    <th class="px-6 py-4 font-semibold">Exploitation (Secteur)</th>
                                    <th class="px-6 py-4 font-semibold">Date d'inscription</th>
                                    <th class="px-6 py-4 font-semibold">Statut</th>
                                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                
                                <?php while($u = $users->fetch_assoc()): 
                                    $initials = strtoupper(substr($u['firstname'], 0, 1) . substr($u['lastname'], 0, 1));
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mr-3">
                                                <?= $initials ?>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800"><?= htmlspecialchars($u['firstname'].' '.$u['lastname']) ?></p>
                                                <p class="text-xs text-gray-500"><?= htmlspecialchars($u['email']) ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($u['farm_name']) ?></p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <?= date('d M Y', strtotime($u['reg_date'])) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="edit_user.php?id=<?= $u['id'] ?>" class="inline-block text-gray-400 hover:text-blue-600 transition-colors" title="Éditer">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if($users->num_rows === 0): ?>
                                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun agriculteur inscrit.</td></tr>
                                <?php endif; ?>
                                
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination simple -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <p class="text-sm text-gray-500">Affichage de <?= $users->num_rows ?> utilisateurs</p>
                        <div class="flex space-x-1 text-sm">
                            <button class="px-3 py-1 border border-gray-200 text-gray-400 rounded hover:bg-gray-50 disabled"><i class="fa-solid fa-chevron-left"></i></button>
                            <button class="px-3 py-1 border border-nature bg-nature text-white rounded">1</button>
                            <button class="px-3 py-1 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded">2</button>
                            <button class="px-3 py-1 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded">3</button>
                            <span class="px-3 py-1 text-gray-400">...</span>
                            <button class="px-3 py-1 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
