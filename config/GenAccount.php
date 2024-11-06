<?php
// Inclure l'autoload de Composer (si nécessaire)
require_once 'vendor/autoload.php';

$host = 'localhost'; // ou '127.0.0.1' si nécessaire
$username = "loic"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "consulat"; // Nom de la base de données

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Initialisation de Faker
$faker = Faker\Factory::create('fr_FR');

// Préparer l'insertion des utilisateurs
$insertUserQuery = "INSERT INTO users (first_name, last_name, email, phone, password, created_at)
                    VALUES (:first_name, :last_name, :email, :phone, :password, :created_at)";
$insertVisaQuery = "INSERT INTO visas (user_id, passport_number, passport_validity, nationality, visa_status, visa_pdf_path)
                    VALUES (:user_id, :passport_number, :passport_validity, :nationality, :visa_status, :visa_pdf_path)";
$insertLotteryQuery = "INSERT INTO lottery (user_id) VALUES (:user_id)";
$insertSessionQuery = "INSERT INTO sessions (user_id, session_token) VALUES (:user_id, :session_token)";

// Préparer les déclarations
$userStmt = $pdo->prepare($insertUserQuery);
$visaStmt = $pdo->prepare($insertVisaQuery);
$lotteryStmt = $pdo->prepare($insertLotteryQuery);
$sessionStmt = $pdo->prepare($insertSessionQuery);

// Générer 100 utilisateurs aléatoires
for ($i = 0; $i < 100; $i++) {
    // Générer des données aléatoires pour l'utilisateur
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $email = $faker->unique()->email;
    $phone = $faker->phoneNumber;
    $password = password_hash($faker->password, PASSWORD_BCRYPT);
    $createdAt = $faker->dateTimeThisDecade->format('Y-m-d H:i:s');

    // Insérer l'utilisateur dans la base de données
    $userStmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':email' => $email,
        ':phone' => $phone,
        ':password' => $password,
        ':created_at' => $createdAt
    ]);

    // Récupérer l'ID de l'utilisateur inséré
    $userId = $pdo->lastInsertId();

    // Insérer un visa pour l'utilisateur
    $passportNumber = $faker->unique()->numerify('P#####');
    $passportValidity = $faker->date('Y-m-d', 'now');
    $nationality = $faker->country;
    $visaStatus = $faker->randomElement(['pending', 'approved', 'rejected']);
    $visaPdfPath = 'path/to/visa/' . $faker->md5 . '.pdf';
    $visaStmt->execute([
        ':user_id' => $userId,
        ':passport_number' => $passportNumber,
        ':passport_validity' => $passportValidity,
        ':nationality' => $nationality,
        ':visa_status' => $visaStatus,
        ':visa_pdf_path' => $visaPdfPath
    ]);

    // Insérer une entrée de loterie pour l'utilisateur
    $lotteryStmt->execute([':user_id' => $userId]);

    // Insérer une session pour l'utilisateur
    $sessionToken = bin2hex(random_bytes(32)); // Générer un token de session aléatoire
    $sessionStmt->execute([':user_id' => $userId, ':session_token' => $sessionToken]);

    echo "Utilisateur $i inséré avec succès\n";
}

echo "Insertion terminée\n";
?>
