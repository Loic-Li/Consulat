<?php

ini_set('display_errors', 1);
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

function sendWinnerEmail($winnerId) {
    global $pdo;

    try {
        if (empty($winnerId) || !is_numeric($winnerId)) {
            throw new Exception("ID du gagnant invalide.");
        }

        $stmt = $pdo->prepare("SELECT email, first_name FROM users WHERE id = :winnerId");
        $stmt->bindParam(':winnerId', $winnerId, PDO::PARAM_INT);
        $stmt->execute();
        $winner = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$winner) {
            throw new Exception("Gagnant introuvable.");
        }

        $winnerEmail = $winner['email'];
        $winnerName = htmlspecialchars($winner['first_name']);

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'consulatoff@gmail.com';
        $mail->Password = 'qfsd zfmp qiid dohe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('votre_email@gmail.com', 'Loterie Nationale');
        $mail->addAddress($winnerEmail, $winnerName);

        $mail->isHTML(true);
        $mail->Subject = 'Félicitations, Vous avez gagné !';
        $mail->Body    = "<h1>Félicitations $winnerName !</h1><p>Vous avez gagné la loterie nationale. Veuillez consulter votre compte pour plus de détails.</p>";
        $mail->AltBody = "Félicitations $winnerName ! Vous avez gagné la loterie nationale.";

        $mail->send();
        return "Email envoyé à $winnerEmail.";
    } catch (Exception $e) {
        return "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}

function runLottery($pdo) {
    $sql = "SELECT * FROM users WHERE is_nationality_assigned = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        $randomIndex = array_rand($users);
        $winner = $users[$randomIndex];

        $updateQuery = "UPDATE users SET is_nationality_assigned = 1 WHERE id = :user_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([':user_id' => $winner['id']]);

        $visaUpdateQuery = "UPDATE visas SET nationality = 'Chine' WHERE user_id = :user_id";
        $visaUpdateStmt = $pdo->prepare($visaUpdateQuery);
        $visaUpdateStmt->execute([':user_id' => $winner['id']]);

        sendWinnerEmail($winner['id']);
        return htmlspecialchars($winner['first_name']) . " " . htmlspecialchars($winner['last_name']);
    } else {
        return "Aucun utilisateur disponible pour la loterie.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manual_draw'])) {
    // Vérifier si l'utilisateur connecté a l'ID 1
    if ($_SESSION['user_id'] == 1) {
        $winnerName = runLottery($pdo);

        $updateScheduleQuery = "UPDATE lottery_schedule SET last_run = NOW(), winner_id = (SELECT id FROM users WHERE first_name = :winner_first_name AND last_name = :winner_last_name LIMIT 1) WHERE id = 1";
        $pdo->prepare($updateScheduleQuery)->execute([':winner_first_name' => explode(' ', $winnerName)[0], ':winner_last_name' => explode(' ', $winnerName)[1]]);
    } else {
        echo "Vous n'êtes pas autorisé à lancer la loterie.";
    }
}

$nextDrawMessage = "Tirage en attente...";

if ($lastRunDate > $oneWeekAgo) {
    $nextDrawMessage = "Tirage disponible prochainement.";
}
?>

<!-- Message Popup en haut de la page -->
<?php if (isset($winnerName) && $winnerName !== "Aucun gagnant"): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Félicitations!</strong> Un gagnant a été sélectionné: <?php echo $winnerName; ?>. Un email a été envoyé.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (isset($winnerName) && $winnerName === "Aucun gagnant"): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Attention!</strong> Aucun gagnant pour ce tirage.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div style="text-align: center;">
    <h1>Résultats de la Loterie Nationale</h1>
    <p>
        <strong>Dernier gagnant :</strong> <?php echo $winnerName; ?><br>
        <?php if ($lastRunDate > $oneWeekAgo) {
            echo $nextDrawMessage . "<span id='countdown'></span>";
        } else {
            echo "Prochain tirage disponible !";
        } ?>
    </p>

    <!-- Ajouter un bouton pour lancer le tirage manuellement uniquement si l'utilisateur a l'ID 1 -->
    <?php if ($isLoggedIn && $_SESSION['user_id'] == 1): ?>
        <form method="POST">
            <button type="submit" name="manual_draw" class="btn btn-primary">Lancer la loterie manuellement</button>
        </form>
    <?php elseif ($isLoggedIn): ?>
        <p>Vous devez être l'utilisateur administrateur pour exécuter cette action.</p>
    <?php else: ?>
        <p>Vous devez être connecté pour exécuter cette action.</p>
    <?php endif; ?>
</div>

<script>
// Timer countdown
<?php if ($lastRunDate > $oneWeekAgo): ?>
    var endDate = new Date("<?php echo $lastRunDate->format('Y-m-d H:i:s'); ?>");

    function updateCountdown() {
        var now = new Date();
        var diff = endDate - now;

        if (diff <= 0) {
            document.getElementById("countdown").innerText = "Le prochain tirage est disponible !";
            clearInterval(countdownInterval);
        } else {
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerText = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        }
    }

    var countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown();  // Call immediately to show the initial countdown.
<?php endif; ?>
</script>

<?php include_once '../includes/footer.php'; ?>
