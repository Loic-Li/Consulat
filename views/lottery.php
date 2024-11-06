<?php
ini_set('display_errors', 1);

// Définir le niveau d'erreur à afficher (toutes les erreurs, y compris les notices et les avertissements)
error_reporting(E_ALL);
session_start();

// Inclure la configuration de la base de données
include_once __DIR__ . '/../config/db.php';
require __DIR__ . '/../vendor/autoload.php';


$isOnIndex = false;
$isLoggedIn = isset($_SESSION['user_id']);
$title = "National Lottery";

include_once '../includes/header.php';

// Vérifier la dernière exécution de la loterie
$scheduleQuery = "SELECT last_run, winner_id FROM lottery_schedule WHERE id = 1";
$scheduleStmt = $pdo->query($scheduleQuery);
$scheduleData = $scheduleStmt->fetch(PDO::FETCH_ASSOC);

$lastRun = $scheduleData['last_run'];
$winnerId = $scheduleData['winner_id'];

// Vérifier si un gagnant a été sélectionné et récupérer ses informations
if ($winnerId) {
    $winnerQuery = "SELECT first_name, last_name FROM users WHERE id = :user_id";
    $winnerStmt = $pdo->prepare($winnerQuery);
    $winnerStmt->execute([':user_id' => $winnerId]);
    $winner = $winnerStmt->fetch(PDO::FETCH_ASSOC);
    $winnerName = htmlspecialchars($winner['first_name']) . " " . htmlspecialchars($winner['last_name']);
} else {
    $winnerName = "Aucun gagnant";
}

// Convertir les dates en objets DateTime pour comparaison
$lastRunDate = new DateTime($lastRun);
$oneWeekAgo = new DateTime();
$oneWeekAgo->modify('-1 week');

// Fonction pour envoyer un email au gagnant
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Exemple de fonction pour envoyer un email au gagnant
function sendWinnerEmail($winnerId) {
    global $pdo;  // Utilisation de la connexion PDO

    // Récupérer l'email du gagnant à partir de la base de données
    $stmt = $pdo->prepare("SELECT email, name FROM users WHERE id = :winnerId");
    $stmt->bindParam(':winnerId', $winnerId, PDO::PARAM_INT);
    $stmt->execute();
    $winner = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($winner) {
        $winnerEmail = $winner['email'];
        $winnerName = $winner['name'];

        // Configuration de l'email avec PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurer le serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Exemple pour Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'votre-email@gmail.com';  // Votre adresse email
            $mail->Password = 'votre-mot-de-passe';    // Votre mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire
            $mail->setFrom('votre-email@gmail.com', 'Loterie Nationale');
            $mail->addAddress($winnerEmail, $winnerName);  // Email du gagnant

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Félicitations, vous avez gagné la Loterie Nationale !';
            $mail->Body    = "<h1>Félicitations, $winnerName !</h1>
                              <p>Nous avons le plaisir de vous annoncer que vous avez gagné la Loterie Nationale et que vous avez maintenant une nationalité chinoise.</p>
                              <p>Vous pouvez maintenant commencer à profiter de votre visa !</p>
                              <p>Merci de participer à notre loterie !</p>";

            // Envoyer l'email
            $mail->send();
            echo 'L\'email a été envoyé au gagnant.';
        } catch (Exception $e) {
            echo "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
        }
    } else {
        echo "Gagnant introuvable.";
    }
}


// Fonction pour lancer la loterie
function runLottery($pdo) {
    $sql = "SELECT * FROM users WHERE is_nationality_assigned = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        $randomIndex = array_rand($users);
        $winner = $users[$randomIndex];

        // Mettre à jour la base de données
        $updateQuery = "UPDATE users SET is_nationality_assigned = 1 WHERE id = :user_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([':user_id' => $winner['id']]);

        $visaUpdateQuery = "UPDATE visas SET nationality = 'Chine' WHERE user_id = :user_id";
        $visaUpdateStmt = $pdo->prepare($visaUpdateQuery);
        $visaUpdateStmt->execute([':user_id' => $winner['id']]);

        // Envoyer un email au gagnant
        sendWinnerEmail($winner['email'], htmlspecialchars($winner['first_name']) . " " . htmlspecialchars($winner['last_name']));

        return htmlspecialchars($winner['first_name']) . " " . htmlspecialchars($winner['last_name']);
    } else {
        return "Aucun utilisateur disponible pour la loterie.";
    }
}

// Si le formulaire a été soumis pour un tirage manuel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manual_draw'])) {
    // Exécuter la loterie manuellement
    $winnerName = runLottery($pdo);

    // Mettre à jour la dernière date d'exécution de la loterie
    $updateScheduleQuery = "UPDATE lottery_schedule SET last_run = NOW(), winner_id = (SELECT id FROM users WHERE first_name = :winner_first_name AND last_name = :winner_last_name LIMIT 1) WHERE id = 1";
    $pdo->prepare($updateScheduleQuery)->execute([':winner_first_name' => explode(' ', $winnerName)[0], ':winner_last_name' => explode(' ', $winnerName)[1]]);
}

// Définir un message de tirage en attente
$nextDrawMessage = "Tirage en attente...";  // Message par défaut

if ($lastRunDate > $oneWeekAgo) {
    // Si la loterie a été effectuée récemment, afficher un message de délai
    $nextDrawMessage = "Tirage disponible prochainement.";
}

?>

<!-- HTML pour afficher les résultats -->
<div style="text-align: center;">
    <h1>Résultats de la Loterie Nationale</h1>
    <p>
        <strong>Dernier gagnant :</strong> <?php echo $winnerName; ?><br>
        <?php
        if ($lastRunDate > $oneWeekAgo) {
            echo $nextDrawMessage . "<span id='countdown'></span>";
        } else {
            echo "Prochain tirage disponible !";
        }
        ?>
    </p>

    <!-- Ajouter un bouton pour lancer le tirage manuellement -->
    <?php if ($isLoggedIn): ?>
        <form method="POST">
            <button type="submit" name="manual_draw" class="btn btn-primary">Lancer la loterie manuellement</button>
        </form>
    <?php else: ?>
        <p>Vous devez être connecté pour exécuter cette action.</p>
    <?php endif; ?>
</div>

<script>
// Vérifier si un timer est nécessaire
<?php if ($lastRunDate > $oneWeekAgo): ?>
    // Date et heure actuelle
    var endDate = new Date("<?php echo $lastRunDate->format('Y-m-d H:i:s'); ?>");

    // Mettre à jour la fonction du compte à rebours
    function updateCountdown() {
        var now = new Date();
        var diff = endDate - now;

        // Si le temps est écoulé, mettre à jour le texte
        if (diff <= 0) {
            document.getElementById("countdown").innerText = "Le prochain tirage est disponible !";
            clearInterval(countdownInterval);
        } else {
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerText = days + " jours " + hours + "h " + minutes + "m " + seconds + "s ";
        }
    }

    // Mettre à jour toutes les secondes
    var countdownInterval = setInterval(updateCountdown, 1000);
<?php else: ?>
    document.getElementById("countdown").innerText = "Prochain tirage disponible !";
<?php endif; ?>
</script>

<?php include_once '../includes/footer.php'; ?>
