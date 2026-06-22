<?php

try {
    $mysqlClient = new PDO(
        "mysql:host=mysql;dbname=sherob;charset=utf8mb4",
        "root",
        "root"
    );

    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

function bonjour() {
    include '../Includes/header.php';
}

/* ------------------ SUPPRESSION ------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {

    $deleteAgent = $mysqlClient->prepare(
        'DELETE FROM Agents_Sherob WHERE id = :id'
    );

    $deleteAgent->execute([
        'id' => $_POST['delete_id']
    ]);
}

/* ------------------ MODIFICATION ------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {

    $updateAgent = $mysqlClient->prepare(
        'UPDATE Agents_Sherob
         SET full_name = :full_name,
             date_naissance = :date_naissance,
             role = :role,
             mission = :mission
         WHERE id = :id'
    );

    $updateAgent->execute([
        'full_name'      => $_POST['full_name'],
        'date_naissance' => $_POST['date_naissance'],
        'role'           => $_POST['role'],
        'mission'        => $_POST['mission'],
        'id'             => $_POST['edit_id']
    ]);
}

/* ------------------ INSERTION ------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name']) && !isset($_POST['edit_id'])) {

    $insertAgents = $mysqlClient->prepare(
        'INSERT INTO Agents_Sherob
        (full_name, date_naissance, role, mission)
        VALUES
        (:full_name, :date_naissance, :role, :mission)'
    );

    $insertAgents->execute([
        'full_name'      => $_POST['full_name'],
        'date_naissance' => $_POST['date_naissance'],
        'role'           => $_POST['role'],
        'mission'        => $_POST['mission']
    ]);
}

/* ------------------ EDITION ------------------ */
$agentAModifier = null;

if (isset($_GET['edit_id'])) {

    $selectAgent = $mysqlClient->prepare(
        'SELECT * FROM Agents_Sherob WHERE id = :id'
    );

    $selectAgent->execute([
        'id' => $_GET['edit_id']
    ]);

    $agentAModifier = $selectAgent->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agents</title>

<style>
body {
    text-align: center;
    background-color: #7a0101;
    color: whitesmoke;
    font-family: Arial;
} button {
            padding: 10px 20px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }

main {
    text-align: left;
}

input {
    margin: 5px;
    padding: 5px;
}

.btn-modifier {
    background-color: orange;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.btn-supprimer {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.btn-sauvegarder {
    background-color: green;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
</style>
</head>

<body>

<?php bonjour(); ?>

<main>

<?php if ($agentAModifier): ?>

<h3>Modifier agent</h3>

<form method="POST">

    <input type="hidden" name="edit_id" value="<?= $agentAModifier['id'] ?>">

    <input type="text" name="full_name"
        value="<?= htmlspecialchars($agentAModifier['full_name']) ?>"
        placeholder="Nom">

    <input type="date" name="date_naissance"
        value="<?= htmlspecialchars($agentAModifier['date_naissance']) ?>">

    <input type="text" name="role"
        value="<?= htmlspecialchars($agentAModifier['role']) ?>"
        placeholder="Rôle">

    <input type="text" name="mission"
        value="<?= htmlspecialchars($agentAModifier['mission']) ?>"
        placeholder="Mission">

    <button type="submit" class="btn-sauvegarder">Sauvegarder</button>

</form>

<?php endif; ?>

<hr>

<?php
$selectAgents = $mysqlClient->prepare('SELECT * FROM Agents_Sherob');
$selectAgents->execute();
$agents = $selectAgents->fetchAll(PDO::FETCH_ASSOC);

foreach ($agents as $agent) {
?>

<div style="border:1px solid white; margin:10px; padding:10px;">

    <p><strong>Nom :</strong> <?= htmlspecialchars($agent['full_name']) ?></p>

    <p><strong>Date naissance :</strong> <?= htmlspecialchars($agent['date_naissance']) ?></p>

    <p><strong>Rôle :</strong> <?= htmlspecialchars($agent['role']) ?></p>

    <p><strong>Mission :</strong> <?= htmlspecialchars($agent['mission']) ?></p>

    <a href="?edit_id=<?= $agent['id'] ?>">
        <button class="btn-modifier">Modifier</button>
    </a>

    <form method="POST" style="display:inline;">
        <input type="hidden" name="delete_id" value="<?= $agent['id'] ?>">
        <button class="btn-supprimer">Supprimer</button>
    </form>

</div>

<?php } ?>

<p>
    <a href="../Login/new.php">
        <button>Nouvelle mission</button>
    </a>
</p>

</main>

</body>
</html>