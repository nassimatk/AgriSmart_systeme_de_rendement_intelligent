<?php
require_once 'db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $farm_name = $conn->real_escape_string($_POST['farm_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check && $check->num_rows > 0) {
        $error = "Cet e-mail est déjà utilisé.";
    } else {
        $sql = "INSERT INTO users (firstname, lastname, farm_name, email, password) 
                VALUES ('$firstname', '$lastname', '$farm_name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur SQL: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AgriSmart Souss-Massa</title>
    
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
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10 font-sans text-gray-800">

    <div class="flex flex-col md:flex-row-reverse bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl w-full mx-4 transition-transform duration-300 hover:shadow-2xl">
        
        <!-- Côté Information / Design -->
        <div class="w-full md:w-2/5 bg-gradient-to-b from-green-800 to-nature-dark text-white p-10 flex flex-col justify-between relative overflow-hidden">
            <!-- Décoration d'arrière-plan -->
            <div class="absolute -top-10 -right-10 opacity-10">
                <i class="fa-solid fa-microchip text-9xl"></i>
            </div>
            
            <div class="relative z-10">
                <a href="login.php" class="flex items-center space-x-2 mb-8 hover:text-green-100 transition-colors">
                    <i class="fa-solid fa-seedling text-3xl drop-shadow-md text-green-300"></i>
                    <span class="text-2xl font-bold tracking-wider drop-shadow-md">AgriSmart</span>
                </a>
                
                <h2 class="text-2xl font-bold leading-tight mb-4">
                    Rejoignez le réseau agricole du futur.
                </h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-8">
                    Déployez nos capteurs intelligents dans vos serres de la région de Souss-Massa pour optimiser vos rendements tout en économisant l'eau.
                </p>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-check text-green-400 mt-1 mr-3"></i>
                        <span class="text-sm font-medium text-gray-100">Surveillance temps-réel 24/7</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-check text-green-400 mt-1 mr-3"></i>
                        <span class="text-sm font-medium text-gray-100">Analyses prédictives par intelligence artificielle</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-check text-green-400 mt-1 mr-3"></i>
                        <span class="text-sm font-medium text-gray-100">Actionneurs et automatisation</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Côté Formulaire d'Inscription -->
        <div class="w-full md:w-3/5 p-8 lg:p-10 flex flex-col justify-center bg-white">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-1">Créer un compte</h3>
                <p class="text-gray-500 text-sm">Enregistrez votre nouvelle exploitation agricole.</p>
            </div>
            
            <form method="POST" action="signup.php" class="space-y-4">
                <?php if(!empty($error)): ?>
                <div class="bg-red-50 text-red-600 p-3 rounded text-sm font-medium"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if(!empty($success)): ?>
                <div class="bg-green-50 text-green-600 p-3 rounded text-sm font-medium"><?= htmlspecialchars($success) ?></div>
                <script>setTimeout(()=>window.location.href='login.php', 2000);</script>
                <?php endif; ?>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Prénom -->
                    <div>
                        <label for="firstname" class="block text-sm font-semibold text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="firstname" id="firstname" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-nature focus:border-nature outline-none transition-all" placeholder="Ahmed" required>
                    </div>
                    <!-- Nom -->
                    <div>
                        <label for="lastname" class="block text-sm font-semibold text-gray-700 mb-1">Nom</label>
                        <input type="text" name="lastname" id="lastname" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-nature focus:border-nature outline-none transition-all" placeholder="Amrani" required>
                    </div>
                </div>

                <!-- Nom de l'exploitation -->
                <div>
                    <label for="farm-name" class="block text-sm font-semibold text-gray-700 mb-1">Nom de l'exploitation</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-tractor text-gray-400 group-focus-within:text-nature transition-colors"></i>
                        </div>
                        <input type="text" name="farm_name" id="farm-name" class="pl-10 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-nature focus:border-nature outline-none transition-all" placeholder="Domaine Chtouka" required>
                    </div>
                </div>

                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Adresse E-mail</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400 group-focus-within:text-nature transition-colors"></i>
                        </div>
                        <input type="email" name="email" id="email" class="pl-10 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-nature focus:border-nature outline-none transition-all" placeholder="contact@domaine.ma" required>
                    </div>
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-shield-halved text-gray-400 group-focus-within:text-nature transition-colors"></i>
                        </div>
                        <input type="password" name="password" id="password" class="pl-10 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-nature focus:border-nature outline-none transition-all" placeholder="••••••••" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Doit contenir au moins 8 caractères.</p>
                </div>
                
                <!-- Conditions -->
                <div class="flex items-start mt-2">
                    <input id="terms" type="checkbox" class="mt-0.5 h-4 w-4 text-nature focus:ring-nature border-gray-300 rounded cursor-pointer transition-colors" required>
                    <label for="terms" class="ml-2 block text-xs font-medium text-gray-600 cursor-pointer">
                        J'accepte les <a href="#" class="text-nature hover:underline">conditions d'utilisation</a> d'AgriSmart et la politique de confidentialité.
                    </label>
                </div>
                
                <!-- Bouton d'inscription -->
                <button type="submit" class="w-full bg-nature hover:bg-nature-light text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 mt-2">
                    Créer mon exploitation
                </button>
            </form>
            
            <div class="mt-6 text-center border-t border-gray-100 pt-5">
                <p class="text-sm text-gray-600">
                    Vous possédez déjà un système ? 
                    <a href="login.php" class="font-bold text-nature hover:text-nature-light hover:underline transition-colors">Se connecter</a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>
