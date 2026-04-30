<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenue, {{ Auth::user()->name }}!</h1>
    <p>Ceci est votre tableau de bord utilisateur.</p>
    <p>Vous pouvez voir vos annonces, messages, et gérer votre profil ici.</p>
    
</body>
</html>