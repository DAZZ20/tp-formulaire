<?php
$prenom = '';
$nom = '';
$email = '';
$age = '';
$filiere = '';
$motivation = '';
$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $filiere = $_POST['filiere'] ?? '';
    $motivation = $_POST['motivation'] ?? '';
    $reglement = isset($_POST['reglement']);

    
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est obligatoire.";
    }

    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email est invalide.";
    }

    if (!is_numeric($age) || $age < 16 || $age > 30) {
        $erreurs[] = "L'âge doit être un nombre entre 16 et 30.";
    }

    if (empty($filiere)) {
        $erreurs[] = "Veuillez choisir une filière.";
    }

    if (strlen($motivation) < 30) {
        $erreurs[] = "La motivation doit contenir au moins 30 caractères.";
    }

    if (!$reglement) {
        $erreurs[] = "Vous devez accepter le règlement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Candidature Club Informatique</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php if (empty($erreurs) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>

    <h1>Candidature reçue !</h1>

    <p><strong>Nom :</strong> <?= $nom ?> <?= $prenom ?></p>
    <p><strong>Email :</strong> <?= $email ?></p>
    <p><strong>Âge :</strong> <?= $age ?></p>
    <p><strong>Filière :</strong> <?= $filiere ?></p>

    <p><strong>Motivation :</strong></p>
    <p><?= nl2br($motivation) ?></p>

    <p>Votre candidature a bien été enregistrée. Nous vous contacterons par email.</p>

    <a href="candidature.php">Soumettre une nouvelle candidature</a>

<?php else: ?>

    <?php if (!empty($erreurs)): ?>
        <ul class="erreurs">
            <?php foreach ($erreurs as $e): ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="candidature.php" method="POST">

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= $prenom ?>">

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= $nom ?>">

        <label>Email :</label>
        <input type="email" name="email" value="<?= $email ?>">

        <label>Âge :</label>
        <input type="number" name="age" value="<?= $age ?>">

        <label>Filière :</label>
        <select name="filiere">
            <option value="">-- Choisir --</option>
            <option value="Informatique" <?= $filiere === 'Informatique' ? 'selected' : '' ?>>Informatique</option>
            <option value="Électronique" <?= $filiere === 'Électronique' ? 'selected' : '' ?>>Électronique</option>
            <option value="Mécanique" <?= $filiere === 'Mécanique' ? 'selected' : '' ?>>Mécanique</option>
            <option value="Autre" <?= $filiere === 'Autre' ? 'selected' : '' ?>>Autre</option>
        </select>

        <label>Lettre de motivation :</label>
        <textarea name="motivation" rows="6"><?= $motivation ?></textarea>

        <label>
            <input type="checkbox" name="reglement" value="1" <?= isset($reglement) && $reglement ? 'checked' : '' ?>>
            J'ai lu et j'accepte le règlement du club.
        </label>

        <button type="submit">Envoyer ma candidature</button>

    </form>

<?php endif; ?>

</body>
</html>