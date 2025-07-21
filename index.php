<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 25px;
        }

        .logo {
            max-height: 200px;
            width: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            margin-bottom: 30px;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn.secondary {
            background: #28a745;
        }

        .btn.secondary:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>
<div class="container">
 <img src="logo.png.jpg" alt="Logo" class="logo">
        <h1>Bienvenue</h1>
        <a href="Inscription.php" class="btn secondary">Inscription</a>
        <a href="login.php" class="btn">Connexion</a>
    </div>
</body>
</html>