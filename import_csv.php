<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=Agencekech;charset=utf8", "root", "1234");

$csvFile = "Architecte.csv"; 
$table = "Archit"; 

$header = ['NomA'];

if (($handle = fopen($csvFile, "r")) !== false) {

    $placeholders = implode(",", array_fill(0, count($header), "?"));
    $insertSQL = "INSERT INTO `$table` (`" . implode("`,`", $header) . "`) VALUES ($placeholders)";
    $stmt = $pdo->prepare($insertSQL);

    $line = 1;
    while (($data = fgetcsv($handle, 1000, ";")) !== false) {
        try {
            $stmt->execute($data);
            echo "✅ Ligne $line insérée.<br>";
        } catch (PDOException $e) {
            echo "❌ Erreur ligne $line : " . $e->getMessage() . "<br>";
        }
        $line++;
    }

    fclose($handle);
    echo "<br>✅ Importation terminée.";
} else {
    echo "❌ Impossible d'ouvrir le fichier CSV.";
}
?>
