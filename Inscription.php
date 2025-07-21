<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RECHERCHE DE DOSSIER URBANISTIQUE</title>
</head>
<body>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43e97b, #38f9d7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .signup-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .signup-container input[type="text"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .signup-container button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signup-container button:hover {
            background-color: #1e7e34;
        }

        .signup-container .link {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }

        .signup-container .link a {
            color: #28a745;
            text-decoration: none;
        }

        .signup-container .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Créer un compte</h2>
        <form action="traitement_inscription.php" method="post">
            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <div class="link">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
        </div>
    </div>
   
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($nom) && !empty($email)) {
        $ligne = $nom . " | " . $email . "\n";
        file_put_contents("inscrits.txt", $ligne, FILE_APPEND);
        echo " Inscription enregistrée.";
    } else {
        echo " Nom ou email manquant.";
    }
}
?>
   <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];
    $date = date("Y-m-d H:i:s");

    
    $nouvel_utilisateur = [
        "nom" => $nom,
        "email" => $email,
        "motdepasse" => $motdepasse,
        "date" => $date
    ];


    $fichier = 'inscrits.json';
    if (file_exists($fichier)) {
        $contenu = file_get_contents($fichier);
        $inscrits = json_decode($contenu, true);
    } else {
        $inscrits = [];
    }

    
    $inscrits[] = $nouvel_utilisateur;

   
    file_put_contents($fichier, json_encode($inscrits, JSON_PRETTY_PRINT));

    echo "Inscription réussie.";
    header("Location: Rechercher.php");
exit();
}

?>
</body>
</html>