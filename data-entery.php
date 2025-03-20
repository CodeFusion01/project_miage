<?php 
    include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Informations</title>
    <link rel="stylesheet" href="data-entery.css?v=2">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <div class="image-design">
            <h1>Clients Informations</h1>
            <img src="illustration-du-concept-formes.png">
        </div>

        

        <div class="form">

<?php
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        function cleanInput($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }


        $nome = cleanInput($_POST['nome'] ?? '');
        $prenome = cleanInput($_POST['prenome'] ?? '');
        $categorie = cleanInput($_POST['categorie'] ?? '');
        $ville = cleanInput($_POST['ville'] ?? '');
        $phone = cleanInput($_POST['phone'] ?? '');
        $gmail = cleanInput($_POST['gmail'] ?? '');
        $poste = cleanInput($_POST['poste'] ?? '');

        // Handle checkbox values: check if they are checked (set to 1 if checked, 0 if not)
        $marternelle = isset($_POST['marternelle']) ? 1 : 0;
        $primaire = isset($_POST['primaire']) ? 1 : 0;
        $college = isset($_POST['college']) ? 1 : 0;
        $lycee = isset($_POST['lycee']) ? 1 : 0;

        if (empty($nome)) $errors['nome'] = "name is required!";
        if (empty($prenome)) $errors['prenome'] = "prenome is required!";
        if (empty($categorie)) $errors['categorie'] = "Categorie is required!";
        if (empty($ville)) $errors['ville'] = "ville is required!";
        if (empty($gmail)) $errors['gmail'] = "gmail is required!";
        if (empty($phone)) $errors['phone'] = "phone is required!";
        if (empty($poste)) $errors['poste'] = "poste is required!";

        
        if (!empty($nome) && !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
            $errors['nome'] = "nome should contain only letters!";
        }
        if (!empty($prenome) && !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenome)) {
            $errors['prenome'] = "prenome should contain only letters!";
        }
        if (!empty($ville) && !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $ville)) {
            $errors['ville'] = "ville should contain only letters!";
        }

        // email validation
        if (!empty($gmail) && !filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
            $errors['gmail'] = "invalide email!";
        }
        // ! INSERT to the table db_client
        if (empty($errors) and isset($_POST['valider'])) {
            try {
                $created_by = $_SESSION['username'];
                $sql = $conn->prepare("INSERT INTO db_client (`nom`, `prenom`, `categorie`, `poste`, `marternelle`, `primaire`, `college`, `lycee`, `ville`, `phone`, `gmail`,`created_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?)");
                $sql->execute([$nome, $prenome, $categorie,$poste,$marternelle,$primaire,$college,$lycee, $ville, $phone, $gmail,$created_by]);
                
                echo '<script>alert("Client added successfully!"); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
                exit();
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>';
            }
        }
        // ! end INSERT to the table db_client
    }
?>
            <form class="form-data" method="POST" action="">
                <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($nome ?? '') ?>">
                <span style="color: red;"><?= $errors['nome'] ?? '' ?></span>

                <input type="text" name="prenome" placeholder="Prenome" value="<?= htmlspecialchars($prenome ?? '') ?>">
                <span style="color: red;"><?= $errors['prenome'] ?? '' ?></span>

                <div class="category-select">
                    <label>Categorie:</label>
                    <select name="categorie" class="category">
                        <option value="">-- chose categorie --</option>
                        <option value="Ecole" <?= (isset($categorie) && $categorie == "Ecole") ? "selected" : "" ?>>Ecole</option>
                        <option value="Ecole superieure" <?= (isset($categorie) && $categorie == "Ecole superieure") ? "selected" : "" ?>>Ecole superieure</option>
                        <option value="Enseignment" <?= (isset($categorie) && $categorie == "Enseignment") ? "selected" : "" ?>>Enseignment</option>
                        <option value="Persone" <?= (isset($categorie) && $categorie == "Persone") ? "selected" : "" ?>>Persone</option>
                        <option value="Entreprise" <?= (isset($categorie) && $categorie == "Entreprise") ? "selected" : "" ?>>Entreprise</option>
                        <option value="Industre" <?= (isset($categorie) && $categorie == "Industre") ? "selected" : "" ?>>Industre</option>
                    </select>
                    <span style="color: red;"><?= $errors['categorie'] ?? '' ?></span>
                </div>

                <input type="text" name="poste" placeholder="Poste" value="<?= htmlspecialchars($poste ?? '') ?>">
                <span style="color: red;"><?= $errors['poste'] ?? '' ?></span>

                <div class="checkbox-select">
                    <div>
                        <input type="checkbox" name="marternelle" value="1" <?= (isset($marternelle) && $marternelle == 1) ? 'checked' : '' ?>> Maternelle
                        <input type="checkbox" name="primaire" value="1" <?= (isset($primaire) && $primaire == 1) ? 'checked' : '' ?>> Primaire
                        <input type="checkbox" name="college" value="1" <?= (isset($college) && $college == 1) ? 'checked' : '' ?>> College
                        <input type="checkbox" name="lycee" value="1" <?= (isset($lycee) && $lycee == 1) ? 'checked' : '' ?>> Lycee
                    </div>
                    <span style="color: red;"><?= $errors['levels'] ?? '' ?></span>
                </div>
                

                <input type="text" name="ville" placeholder="Ville" value="<?= htmlspecialchars($ville ?? '') ?>">
                <span style="color: red;"><?= $errors['ville'] ?? '' ?></span>

                <input type="text" name="phone" placeholder="phone number" value="<?= htmlspecialchars($phone ?? '') ?>">
                <span style="color: red;"><?= $errors['phone'] ?? '' ?></span>

                <input type="email" name="gmail" placeholder="Email" value="<?= htmlspecialchars($gmail ?? '') ?>">
                <span style="color: red;"><?= $errors['gmail'] ?? '' ?></span>


                <input type="submit" class="valider" name="valider" value="Valider">
            </form>
        </div>
    </div>
</body>
</html>
