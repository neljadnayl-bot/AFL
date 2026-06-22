<?php

$message = "";

try {
    $mysqlClient = new PDO(
        "mysql:host=mysql;dbname=sherob;charset=utf8mb4",
        "root",
        "root"
    );

    $mysqlClient->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {

        $message = "Tous les champs sont obligatoires.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Adresse email invalide.";

    } else {

        $checkUser = $mysqlClient->prepare(
            "SELECT user_id
             FROM `Afl-user`
             WHERE email = :email"
        );

        $checkUser->execute([
            'email' => $email
        ]);

        if ($checkUser->fetch()) {

            $message = "Cet email est déjà utilisé.";

        } else {

            $insertUser = $mysqlClient->prepare(
                "INSERT INTO `Afl-user`
                (name, email, password)
                VALUES
                (:name, :email, :password)"
            );

            $insertUser->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>

    <style>
        body {
            text-align: center;
            background-color: #7a0101;
            color: whitesmoke;
            font-family: Arial, sans-serif;
        }

        form {
            margin-top: 30px;
        }

        input {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 250px;
        }

        button {
            padding: 10px 20px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            color: whitesmoke;
            text-decoration: none;
        }

        .message {
            margin: 15px auto;
            padding: 10px;
            width: 300px;
        }
    </style>
</head>

<body>

<?php if (!empty($message)): ?>
    <div class="message">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<a href="../Pages/home.php">← Retour</a>

<h2>Créer un compte AFL</h2>

<nav>
    <a href="./connect.php">Connexion</a> |
    <a href="./form.php">Crée un compte</a>
</nav>

<form method="POST">

    <input
        type="text"
        name="name"
        placeholder="Nom"
        required
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Mot de passe"
        required
    >

    <button type="submit">
        S'inscrire
    </button>

</form>

</body>
</html>