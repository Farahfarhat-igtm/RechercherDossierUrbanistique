<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=Agencekech;charset=utf8", "root", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$edit = isset($_GET['edit']);
$CodePrefecture = $CodeCommune = $num = $architecte = $CIN = $DATE_ARRIVEE = $SITUATION = '';
$NATURE_PROJET = $TYPE_PROJET = $SurfaceTerrain = $Date_Commission = $AVIS = $DETAIL_Avis = $Montant_Apaye = '';

if ($edit) {
    $stmt = $pdo->prepare("SELECT * FROM dossier WHERE NumDossier = ?");
    $stmt->execute([$_GET['edit']]);
    $d = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($d) {
        $CodePrefecture = $d['CodePrefecture'];
        $CodeCommune = $d['CodeCommune'];
        $num = $d['NumDossier'];
        $architecte = $d['ARCHITECTE'];
        $CIN = $d['CIN'];
        $DATE_ARRIVEE = $d['DATE_ARRIVEE'];
        $SITUATION = $d['SITUATION'];
        $NATURE_PROJET = $d['NATURE_PROJET'];
        $TYPE_PROJET = $d['TYPE_PROJET'];
        $SurfaceTerrain = $d['SurfaceTerrain'];
        $Date_Commission = $d['Date_Commission'];
        $AVIS = $d['AVIS'];
        $DETAIL_Avis = $d['DETAIL_Avis'];
        $Montant_Apaye = $d['Montant_Apaye'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer toutes les données du formulaire
    $CodePrefecture = $_POST['CodePrefecture'] ?? '';
    $CodeCommune = $_POST['CodeCommune'] ?? '';
    $num = $_POST['num'] ?? '';
    $architecte = $_POST['architecte'] ?? '';
    $CIN = $_POST['CIN'] ?? '';
    $DATE_ARRIVEE = $_POST['DATE_ARRIVEE'] ?? '';
    $SITUATION = $_POST['SITUATION'] ?? '';
    $NATURE_PROJET = $_POST['NATURE_PROJET'] ?? '';
    $TYPE_PROJET = $_POST['TYPE_PROJET'] ?? '';
    $SurfaceTerrain = $_POST['SurfaceTerrain'] ?? '';
    $Date_Commission = $_POST['Date_Commission'] ?? '';
    $AVIS = $_POST['AVIS'] ?? '';
    $DETAIL_Avis = $_POST['DETAIL_Avis'] ?? '';
    $Montant_Apaye = $_POST['Montant_Apaye'] ?? '';

    if ($edit) {
        $stmt = $pdo->prepare("UPDATE dossier SET 
            CodePrefecture = ?, CodeCommune = ?, ARCHITECTE = ?, CIN = ?, DATE_ARRIVEE = ?, SITUATION = ?, 
            NATURE_PROJET = ?, TYPE_PROJET = ?, SurfaceTerrain = ?, Date_Commission = ?, AVIS = ?, DETAIL_Avis = ?, Montant_Apaye = ?
            WHERE NumDossier = ?");
        $stmt->execute([
            $CodePrefecture, $CodeCommune, $architecte, $CIN, $DATE_ARRIVEE, $SITUATION,
            $NATURE_PROJET, $TYPE_PROJET, $SurfaceTerrain, $Date_Commission, $AVIS, $DETAIL_Avis, $Montant_Apaye,
            $num
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO dossier (
            NumDossier, CodePrefecture, CodeCommune, ARCHITECTE, CIN, DATE_ARRIVEE, SITUATION, 
            NATURE_PROJET, TYPE_PROJET, SurfaceTerrain, Date_Commission, AVIS, DETAIL_Avis, Montant_Apaye
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $num, $CodePrefecture, $CodeCommune, $architecte, $CIN, $DATE_ARRIVEE, $SITUATION,
            $NATURE_PROJET, $TYPE_PROJET, $SurfaceTerrain, $Date_Commission, $AVIS, $DETAIL_Avis, $Montant_Apaye
        ]);
    }

    header("Location: dossier.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Dossiers</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: center; font-size: 14px;}
        form { width: 400px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; font-size: 14px;}
        label { display: block; margin-top: 10px; }
        input, select, textarea { width: 100%; padding: 6px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px; width: 100%; }
    </style>
</head>
<body>

<form method="POST">
    <h3><?= $edit ? "Modifier le dossier" : "Ajouter un dossier" ?></h3>

    <label>Numéro de Dossier :</label>
    <input type="text" name="num" value="<?= htmlspecialchars($num) ?>" <?= $edit ? 'readonly' : '' ?> required>

    <label>Code Préfecture :</label>
    <input type="text" name="CodePrefecture" value="<?= htmlspecialchars($CodePrefecture) ?>" >

    <label>Code Commune :</label>
    <input type="text" name="CodeCommune" value="<?= htmlspecialchars($CodeCommune) ?>" >

    <label>Nom Architecte :</label>
    <input type="text" name="architecte" value="<?= htmlspecialchars($architecte) ?>" required>

    <label>CIN :</label>
    <input type="text" name="CIN" value="<?= htmlspecialchars($CIN) ?>" >

    <label>Date d'Arrivée :</label>
    <input type="date" name="DATE_ARRIVEE" value="<?= htmlspecialchars($DATE_ARRIVEE) ?>" >

    <label>Situation :</label>
    <input type="text" name="SITUATION" value="<?= htmlspecialchars($SITUATION) ?>" >

    <label>Nature du Projet :</label>
    <input type="text" name="NATURE_PROJET" value="<?= htmlspecialchars($NATURE_PROJET) ?>" >

    <label>Type du Projet :</label>
    <input type="text" name="TYPE_PROJET" value="<?= htmlspecialchars($TYPE_PROJET) ?>" >

    <label>Surface du Terrain :</label>
    <input type="text" name="SurfaceTerrain" value="<?= htmlspecialchars($SurfaceTerrain) ?>" >

    <label>Date Commission :</label>
    <input type="date" name="Date_Commission" value="<?= htmlspecialchars($Date_Commission) ?>" >

    <label>Avis :</label>
    <input type="text" name="AVIS" value="<?= htmlspecialchars($AVIS) ?>" >

    <label>Détail Avis :</label>
    <textarea name="DETAIL_Avis"><?= htmlspecialchars($DETAIL_Avis) ?></textarea>

    <label>Montant à Payer :</label>
    <input type="text" name="Montant_Apaye" value="<?= htmlspecialchars($Montant_Apaye) ?>" >

    <button type="submit"><?= $edit ? "Enregistrer les modifications" : "Ajouter" ?></button>
</form>

<table>
    <thead>
    <tr>
        <th>Numéro</th>
        <th>Préfecture</th>
        <th>Commune</th>
        <th>Architecte</th>
        <th>CIN</th>
        <th>Date Arrivée</th>
        <th>Situation</th>
        <th>Nature Projet</th>
        <th>Type Projet</th>
        <th>Surface Terrain</th>
        <th>Date Commission</th>
        <th>Avis</th>
        <th>Détail Avis</th>
        <th>Montant Apayé</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $dossiers = $pdo->query("SELECT * FROM dossier ORDER BY NumDossier DESC")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dossiers as $d):
    ?>
        <tr>
            <td><?= htmlspecialchars($d['NumDossier']) ?></td>
            <td><?= htmlspecialchars($d['CodePrefecture']) ?></td>
            <td><?= htmlspecialchars($d['CodeCommune']) ?></td>
            <td><?= htmlspecialchars($d['ARCHITECTE']) ?></td>
            <td><?= htmlspecialchars($d['CIN']) ?></td>
            <td><?= htmlspecialchars($d['DATE_ARRIVEE']) ?></td>
            <td><?= htmlspecialchars($d['SITUATION']) ?></td>
            <td><?= htmlspecialchars($d['NATURE_PROJET']) ?></td>
            <td><?= htmlspecialchars($d['TYPE_PROJET']) ?></td>
            <td><?= htmlspecialchars($d['SurfaceTerrain']) ?></td>
            <td><?= htmlspecialchars($d['Date_Commission']) ?></td>
            <td><?= htmlspecialchars($d['AVIS']) ?></td>
            <td><?= htmlspecialchars($d['DETAIL_Avis']) ?></td>
            <td><?= htmlspecialchars($d['Montant_Apaye']) ?></td>
            <td><a href="?edit=<?= urlencode($d['NumDossier']) ?>">Modifier</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
