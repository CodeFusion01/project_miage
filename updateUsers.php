<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="updateUsers.css" />
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client</title>
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
    include 'conn.php';
    
    if (isset($_GET['id_client']) && !empty($_GET['id_client'])) {
        $id = $_GET['id_client'];
        $stmt = $conn->prepare("SELECT * FROM db_client WHERE id_client = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();

        
        if (!$client) {
            die("Aucun client trouvé avec cet ID.");
        }
    } else {
        die("Erreur: Aucun ID client fourni.");
    }

    // * UPDATE
if (isset($_POST['valider'])) {
    $id_client = $_POST['id_client'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $categorie = $_POST['categorie'];
    $poste = $_POST['poste'];
    $ville = $_POST['ville'];
    $phone = $_POST['phone'];
    $gmail = $_POST['gmail'];

    
    $marternelle = isset($_POST['marternelle']) ? 1 : 0;
    $primaire = isset($_POST['primaire']) ? 1 : 0;
    $college = isset($_POST['college']) ? 1 : 0;
    $lycee = isset($_POST['lycee']) ? 1 : 0;

    
    $stmt = $conn->prepare("UPDATE db_client SET nom = ?, prenom = ?, categorie = ?, poste = ?, ville = ?, phone = ?, gmail = ?, marternelle = ?, primaire = ?, college = ?, lycee = ? WHERE id_client = ?");
    $stmt->bind_param("sssssssiisii", $nom, $prenom, $categorie, $poste, $ville, $phone, $gmail, $marternelle, $primaire, $college, $lycee, $id_client);

    if ($stmt->execute()) {
        echo "<script>alert('Les informations ont été mises à jour avec succès!'); window.location.href='update_client.php?id_client=$id_client';</script>";
        header("Location: All_clients.php");
    } else {
        echo "<script>alert('Erreur lors de la mise à jour!');</script>";
    }
}
?>
            <form class="form-data" method="POST" action="">
                
                <input type="text" name="nom" placeholder="Nome" value="<?= htmlspecialchars($client['nom'] ?? '') ?>">
                
                <input type="text" name="prenom" placeholder="Prenome" value="<?= htmlspecialchars($client['prenom'] ?? '') ?>">

                <div class="category-select">
                    <label>Categorie:</label>
                    <select name="categorie" class="category">
                        <option value="">-- chose categorie --</option>
                        <option value="Ecole" <?= ($client['categorie'] ?? '') == 'Ecole' ? 'selected' : '' ?>>Ecole</option>
                        <option value="Ecole superieure" <?= ($client['categorie'] ?? '') == 'Ecole superieure' ? 'selected' : '' ?>>Ecole superieure</option>
                        <option value="Enseignment" <?= ($client['categorie'] ?? '') == 'Enseignment' ? 'selected' : '' ?>>Enseignment</option>
                        <option value="Persone" <?= ($client['categorie'] ?? '') == 'Persone' ? 'selected' : '' ?>>Persone</option>
                        <option value="Entreprise" <?= ($client['categorie'] ?? '') == 'Entreprise' ? 'selected' : '' ?>>Entreprise</option>
                        <option value="Industre" <?= ($client['categorie'] ?? '') == 'Industre' ? 'selected' : '' ?>>Industre</option>
                    </select>
                </div>

                <input type="text" name="poste" placeholder="Poste" value="<?= htmlspecialchars($client['poste'] ?? '') ?>">
                
                <div class="checkbox-select">
                    <div>
                    <input type="checkbox" name="marternelle" value="1" <?= ($client['marternelle'] ?? 0) == 1 ? 'checked' : '' ?>> Maternelle
                    <input type="checkbox" name="primaire" value="1" <?= ($client['primaire'] ?? 0) == 1 ? 'checked' : '' ?>> Primaire
                    <input type="checkbox" name="college" value="1" <?= ($client['college'] ?? 0) == 1 ? 'checked' : '' ?>> College
                    <input type="checkbox" name="lycee" value="1" <?= ($client['lycee'] ?? 0) == 1 ? 'checked' : '' ?>> Lycee

                    </div>
                </div>
                

                <input type="text" name="ville" placeholder="Ville" value="<?= htmlspecialchars($client['ville'] ?? '') ?>">

                <input type="text" name="phone" placeholder="phone number" value="<?= htmlspecialchars($client['phone'] ?? '') ?>">

                <input type="email" name="gmail" placeholder="Email" value="<?= htmlspecialchars($client['gmail'] ?? '') ?>">

                <input type="submit" class="valider" name="valider" value="Valider">
            </form>
        </div>
    </div>
</body>
</html>