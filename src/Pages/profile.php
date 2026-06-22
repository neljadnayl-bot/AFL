<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/connect.php");
    exit;
}

try {
    $mysqlClient = new PDO(
        "mysql:host=mysql;dbname=sherob;charset=utf8mb4",
        "root",
        "root"
    );
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);

    $stmt = $mysqlClient->prepare("
        UPDATE `Afl-user`
        SET name = :name
        WHERE user_id = :id
    ");

    $stmt->execute([
        'name' => $name,
        'id' => $user_id
    ]);

    $_SESSION['name'] = $name;
    $message = "Profil mis à jour ✔️";
}

$stmt = $mysqlClient->prepare("
    SELECT name, email
    FROM `Afl-user`
    WHERE user_id = :id
");

$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil</title>

<style>
    body {
        text-align: center;
        background-color: #7a0101; /* bordeaux rouge */
        color: whitesmoke;
        font-family: Arial, sans-serif;
        margin: 5px;
    }

    button {
        padding: 10px 20px;
        background: green;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-weight: bold;
    }

    button:hover {
        background: #0a8f0a;
    } a {
        color: whitesmoke;
        text-decoration: none;
    }
</style>
</head>

<body>

<h2>Profil</h2>

<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Déconnexion</a>
</nav>

<?php if ($message): ?>
    <p class="success"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
    <button>Modifier</button>
</form>

</body>
</html>