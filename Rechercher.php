 <?php
session_start();

if (isset($_POST['rechercher'])) {
    $_SESSION['form_data'] = $_POST;
    header("Location: Rechercher.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RECHERCHE DE DOSSIER URBANISTIQUE</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f7fe;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 1800px;  
            width: 100%;
            margin: 0 auto;
        }
        

        h2, h3 {
            color: #333;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #444;
        }

        form input[type="text"],
        form input[type="date"] {
            width: 150px;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .button-group {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .button-group input[type="submit"],
        .button-group button {
            padding: 10px 18px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-btn { background-color: #007bff; color: white; }
        .search-btn:hover { background-color: #0056b3; }
        .logout-btn { background-color: #dc3545; color: white; }
        .logout-btn:hover { background-color: #a71d2a; }
        .import-btn { background-color: #28a745; color: white; }
        .import-btn:hover { background-color: #1e7e34; }

        table {
            border-collapse: collapse;
            margin-top: 30px;
            width: 100%;
            max-width: 1700px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 15px;
            border: 1px solid #ddd;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        .alert {
            color: red;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
   
<h2>RECHERCHE DE DOSSIER URBANISTIQUE</h2>
<form action="Rechercher.php" method="post">
    <label>Numéro de dossier :</label>
    <input type="text" name="NumDossier">

    <label>Nom de l’architecte :</label>
    <input list="architectes" name="ARCHITECTE" id="ARCHITECTE">
    <datalist id="architectes">
        <option value="CHAMI SAMIR">CHAMI SAMIR</option>
        <option value="ABAID ABDERRAHMAN">ABAID ABDERRAHMAN</option>
        <option value="CHAOUKI SARAH">CHAOUKI SARAH</option>
        <option value="BELBACHIR ABDERRAHIM">BELBACHIR ABDERRAHIM</option>
        <option value="HAJJI MOUSSA">HAJJI MOUSSA</option>
        <option value="BELLAFQIH AISSA">BELLAFQIH AISSA</option>
        <option value="AZZOUZ AMIR">AZZOUZ AMIR</option>
    </datalist>

    <label>Commune :</label>
    <input list="communes" name="CodeCommune" id="CodeCommune">
    <datalist id="communes">
        <option value="AIT OURIR">AIT OURIR</option>
        <option value="IJOUKAK">IJOUKAK</option>
        <option value="BAHALLA">BAHALLA</option>
        <option value="ANNAKHIL">ANNAKHIL</option>
        <option value="AR. GUELIZ">AR. GUELIZ</option>
        <option value="MZOUDA">MZOUDA</option>
    </datalist>

    <label>Date Commission :</label>
    <input type="date" name="Date_Commission">

    <div class="button-group">
        <input type="submit" name="rechercher" value="Rechercher" class="search-btn">
        <button type="submit" formaction="deconnexion.php" class="logout-btn">Déconnexion</button>
        <?php if (isset($_SESSION['email']) && $_SESSION['email'] =='sussiif37@gmail.com'): ?>
        <button type="submit" formaction="import_csv.php" class="import-btn">Importer depuis fichier CSV</button>
        <?php endif; ?>

        
    </div>
</form>

<?php
$formData = $_SESSION['form_data'] ?? null;
if ($formData) {
    unset($_SESSION['form_data']);
    $conn = new mysqli("127.0.0.1", "root", "1234", "Agencekech");
    if ($conn->connect_error) die("Erreur de connexion : " . $conn->connect_error);

    $NumDossier = $formData['NumDossier'] ?? '';
    $nom = $formData['ARCHITECTE'] ?? '';
    $commune = $formData['CodeCommune'] ?? '';
    $date = $formData['Date_Commission'] ?? '';

    $sql = "SELECT * FROM Dossier WHERE 1=1";
    if (!empty($NumDossier)) $sql .= " AND NumDossier LIKE '%$NumDossier%'";
    if (!empty($nom)) $sql .= " AND ARCHITECTE LIKE '%$nom%'";
    if (!empty($commune)) $sql .= " AND CodeCommune LIKE '%$commune%'";
    if (!empty($date)) $sql .= " AND Date_Commission = '$date'";

    $result = $conn->query($sql);
    $problemes = [];

    if ($result->num_rows > 0) {
        echo "<h3>Résultats :</h3><table><thead><tr>";
        echo "<th>Prefecture</th><th>Commune</th><th>NumDossier</th><th>CIN</th><th>Date arrivée</th><th>Architecte</th><th>Situation</th><th>Nature</th><th>Type</th><th>Surface</th><th>REF</th><th>Date Com.</th><th>Avis</th><th>Détail</th><th>Montant</th><th>Obtenir Ticket</th>";
        if (isset($_SESSION['email']) && $_SESSION['email'] == 'sussiif37@gmail.com') {
            echo "<th>Modifier</th><th>Ajouter</th>";
        }
        echo "</tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['CodePrefecture']}</td><td>{$row['CodeCommune']}</td><td>{$row['NumDossier']}</td><td>{$row['CIN']}</td><td>{$row['DATE_ARRIVEE']}</td><td>{$row['ARCHITECTE']}</td><td>{$row['SITUATION']}</td><td>{$row['NATURE_PROJET']}</td><td>{$row['TYPE_PROJET']}</td><td>{$row['SurfaceTerrain']}</td><td>{$row['REF_FONCIER']}</td><td>{$row['Date_Commission']}</td><td>{$row['AVIS']}</td><td>{$row['DETAIL_Avis']}</td><td>{$row['Montant_Apaye']}</td>";
            echo "<td>" . ((strtolower($row['AVIS']) === 'favorable' && floatval($row['Montant_Apaye']) > 0) ? "<a href='Ticket.php?dossier=" . urlencode($row['NumDossier']) . "'>Obtenir Ticket</a>" : "<span style='color:gray;'>Non dispo</span>") . "</td>";
            if (isset($_SESSION['email']) && $_SESSION['email'] == 'sussiif37@gmail.com') {
                echo "<td><a href='dossier.php?id={$row['NumDossier']}'>Modifier</a></td><td><a href='dossier.php?id={$row['NumDossier']}'>Ajouter</a></td>";
            }
            echo "</tr>";

            if (strtolower($row['AVIS']) != "favorable" || floatval($row['Montant_Apaye']) <= 0) {
                $problemes[] = "⚠️ Problème dans le dossier N°{$row['NumDossier']}";
            }
        }

        echo "</tbody></table>";

        if (count($problemes) > 0) {
            echo "<div class='alert'>" . implode("<br>", $problemes) . "<br>Un message a été envoyé à l'administrateur.</div>";
            mail("sussiif37@gmail.com", "⚠️ Alerte Dossiers", implode("\n", $problemes), "From: noreply@tonsite.com");
        } else {
            echo "<p style='color:green;font-weight:bold;'>✅ Tous les dossiers sont corrects.</p>";
        }
    } else {
        echo "<p>Aucun résultat trouvé.</p>";
    }
    $conn->close();
}
?>
</div>
</body>
</html>
