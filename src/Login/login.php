<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à Cherob</title>
    <style>
      form {
            text-align: center;
        }
        h1 {
            text-align: center;
        }  body {
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
    </style>
</head>
<body>
    <h1>Connexion</h1>
    <aside>
        <button href="Login/login.php">User 1</button>
    </aside>
    <form method="post" action="../index.php">
        <label for="pass"><h2>AFL</h2></label> <br>
        <p>
            <input type="password" name="pass" id="pass" required>
            <input type="submit" value="Connexion" class="btn btn-prymary"> 
        </p> 
    </form>
</body>
</html>