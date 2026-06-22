<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        } a {
            color: whitesmoke;
        }
    </style>
</head>
<body>
    <a href="../Pages/agents.php"> <- Retour</a>
    <form method="post" action="../Pages/agents.php">
        <label for="id">Numéro de Mission</label> : <br>
        <input type="text" name="id" id="id" required> <hr>
        <label for="name">Prénom de l'agent</label> : <br>
        <input type="text" name="full_name" id="name" required> <hr>
        <label for="role">Role de la mission</label>  : <br>
        <input type="text" name="role" id="role" required>  <hr>
        <label for="age">date</label>  : <br>
        <input type="date" name="date_naissance" id="age">
        <p>
            <label for="ameliorer">Mission</label><br>
            <textarea name="mission" id="ameliorer" required></textarea>
        </p>
        <button type="submit" class="btn btn-prymary">Envoyer</button>
    </form>
</body>
</html>