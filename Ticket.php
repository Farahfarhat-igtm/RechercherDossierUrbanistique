<!DOCTYPE html>
<html lang="fr">
    <body>
        <button onclick="window.print()" style="margin-bottom: 20px;">🖨️ Imprimer le Ticket</button>

        <style>
            @media print {
                     body * {
                      visibility: hidden;
                            }

                   .ticket, .ticket * {
                   visibility: visible;
                        }

            .ticket {
                  position: absolute;
                  left: 0;
                  top: 0;
                  width: 100%;
                  margin: 0;
                  padding: 0;
                    }

            button {
                 display: none;
                   }
                 }


            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                padding: 30px;
            }
            h2 {
                color: #333;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }
            table, th, td {
                border: 1px solid #aaa;
            }
            th, td {
                padding: 8px 12px;
            }
            .alert {
                padding: 15px;
                margin-top: 20px;
                border: 1px solid red;
                background-color: #ffe6e6;
                color: #b30000;
                font-weight: bold;
            }
        </style>

<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=Agencekech;charset=utf8", "root", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['dossier'])) {
    $NumDossier = $_GET['dossier'];

    $stmt = $pdo->prepare("SELECT NumTicket FROM Tickets WHERE NumDossier = ?");
    $stmt->execute([$NumDossier]);
    $ticket = $stmt->fetch();

    if ($ticket) {
        $numero = $ticket['NumTicket'];
    } else {
        $stmt = $pdo->query("SELECT MAX(NumTicket) AS max_num FROM Tickets");
        $last = $stmt->fetch();
        $numero = $last['max_num'] ? $last['max_num'] + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO Tickets (NumDossier, NumTicket) VALUES (?, ?)");
        $stmt->execute([$NumDossier, $numero]);
    }

    $stmt = $pdo->prepare("SELECT * FROM dossier WHERE NumDossier = ?");
    $stmt->execute([$NumDossier]);
    $dossier = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dossier) {
        $dateTicket = date("Y-m-d");

        echo "<div class='ticket' style='border:1px solid #ccc; padding:20px; width:400px; margin:auto; font-family:Arial'>";
        echo "<h2>🎟️ Ticket n°$numero généré pour le dossier n°$NumDossier</h2>";
        echo "<h3>🗂️ Informations du Dossier</h3>";
        
        echo "<p><strong>CIN:</strong> " . htmlspecialchars($dossier['CIN']) . "</p>";
        echo "<p><strong>Nom Architecte:</strong> " . htmlspecialchars($dossier['ARCHITECTE']) . "</p>";
        echo "<p><strong>Date Arrivee:</strong> " . htmlspecialchars($dossier['DATE_ARRIVEE']) . "</p>";
        echo "<p><strong>Situation:</strong> " . htmlspecialchars($dossier['SITUATION']) . "</p>";
        echo "<p><strong>Nature du Projet:</strong> " . htmlspecialchars($dossier['NATURE_PROJET']) . "</p>";
        echo "<p><strong>Type du Projet:</strong> " . htmlspecialchars($dossier['TYPE_PROJET']) . "</p>";
        echo "<p><strong>Surface du terrain:</strong> " . htmlspecialchars($dossier['SurfaceTerrain']) . " m²</p>";
        echo "<p><strong>Ref Foncier:</strong> " . htmlspecialchars($dossier['REF_FONCIER']) . "</p>";
        echo "<p><strong>Date Commission:</strong> " . htmlspecialchars($dossier['Date_Commission']) . "</p>";
        echo "<p><strong>Avis:</strong> " . htmlspecialchars($dossier['AVIS']) . "</p>";
        echo "<p><strong>Detail Avis:</strong> " . htmlspecialchars($dossier['DETAIL_Avis']) . "</p>";
        echo "<p><strong>Montant A paye:</strong> " . htmlspecialchars($dossier['Montant_Apaye']) . "</p>";
        echo "<p style='text-align: right;'><strong>Marrakech le</strong> " . $dateTicket . "</p>";

        echo "</div>";
        
    } else {
        echo "<p style='color:red;'>Dossier introuvable dans la base de données.</p>";
    }

} else {
    echo "Aucun dossier sélectionné.";
}
?>
    </body>
</html>
