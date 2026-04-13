<?php
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $farm_name = $conn->real_escape_string($_POST['farm_name']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if email belongs to someone else
    $check = $conn->query("SELECT id FROM users WHERE email='$email' AND id != $id");
    if ($check && $check->num_rows > 0) {
        $error = "Cet e-mail est déjà utilisé par un autre utilisateur.";
    } else {
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', farm_name='$farm_name', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success = "Utilisateur mis à jour avec succès.";
        } else {
            $error = "Erreur de mise à jour: " . $conn->error;
        }
    }
}

$result = $conn->query("SELECT * FROM users WHERE id=$id AND role='user'");
if ($result->num_rows == 0) {
    die("Utilisateur introuvable.");
}
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], },
                    colors: { nature: { DEFAULT: '#2D6A4F', light: '#40916C', dark: '#1B4332', } }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex h-screen text-gray-800">
    <div class="m-auto w-full max-w-lg bg-white p-8 rounded-xl shadow-lg border border-gray-100 relative">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-user-pen mr-2 text-nature"></i>Modifier l'Agriculteur</h2>
            <a href="admin.php" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fa-solid fa-xmark text-xl"></i></a>
        </div>
        
        <?php if(!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm font-medium">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 text-sm font-medium">
            <i class="fa-solid fa-circle-check mr-2"></i><?= htmlspecialchars($success) ?>
        </div>
        <script>setTimeout(() => window.location.href = 'admin.php', 2000);</script>
        <?php endif; ?>

        <form method="POST" action="edit_user.php?id=<?= $id ?>" class="space-y-5">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Prénom</label>
                    <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-nature focus:border-nature transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom</label>
                    <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-nature focus:border-nature transition-all" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Exploitation</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-tractor text-gray-400 group-focus-within:text-nature transition-colors"></i>
                    </div>
                    <input type="text" name="farm_name" value="<?= htmlspecialchars($user['farm_name']) ?>" class="pl-10 w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-nature focus:border-nature transition-all" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">E-mail</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-gray-400 group-focus-within:text-nature transition-colors"></i>
                    </div>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="pl-10 w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-nature focus:border-nature transition-all" required>
                </div>
            </div>
            
            <div class="pt-6 flex justify-end space-x-3 border-t border-gray-100 mt-6">
                <a href="admin.php" class="px-5 py-2.5 bg-transparent border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-800 transition-colors font-medium">Annuler</a>
                <button type="submit" class="px-5 py-2.5 bg-nature text-white rounded-lg hover:bg-nature-light shadow-md hover:shadow-lg transition-all font-semibold flex items-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</body>
</html>
