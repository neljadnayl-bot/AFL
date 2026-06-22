<?php
session_start();

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

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $mysqlClient->prepare("
        SELECT user_id, name, password
        FROM `Afl-user`
        WHERE email = :email
    ");

    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];

        header("Location: dashboard.php");
        exit;

    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion</title>

<?= "" ?>
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

<a href="../Pages/home.php">← Retour</a>

<h2>Connexion</h2>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<nav>
    <a href="connect.php">Connexion</a> |
    <a href="form.php">Créer un compte</a>
</nav>

<form method="POST" action="../Pages/dashboard.php">
    <input type="email" name="email" placeholder="Email" required> <br>
    <input type="password" name="password" placeholder="Mot de passe" required> <br>
    <button>Se connecter</button>
</form>

</body>
</html>