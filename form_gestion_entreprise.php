 
 
 <?php

           session_start();
    
 
    include 'conn.php';  
   
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $matricule = $_POST['matricule'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $poste = $_POST['poste'];
        $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : "null";
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $ville = $_POST['ville'];
        $zone = $_POST['zone'];
        $created_by = $_SESSION['username'];

         $ville_id = $_POST['ville'];
            $ville_name = '';

            // جلب اسم المدينة من جدول setting_villes
            $query = $conn->query("SELECT ville FROM setting_villes WHERE id = '$ville_id'");
            if ($query && $row = $query->fetch_assoc()) {
                $ville_name = $row['ville'];
            } else {
                $ville_name = "غير معروف"; // لو لم يجد المدينة
            }

        $stmt = $conn->prepare('INSERT INTO `gestion_entreprise`( `matricule`, `nom`, `prenom`, `categorie`, `poste`, `ville`, `phone`, `gmail`, `zone`, `created_by`) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param('ssssssssss', $matricule, $nom, $prenom, $categorie, $poste, $ville_name, $phone, $email, $zone, $created_by);

        $result = $stmt->execute();
        if(!$result){
            echo 'data is not inserted ..';
        };
        $stmt->close();



    }



?>





<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="form_gestion_entreprise.css?v=3" />
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Clients</title>
    </head>
    <body>
        <?php include 'menu.php'; ?>

    <div class="container">
        <div class="imgform">
            <img src="imgform.png" alt="">
        </div>

        <div class="form">
            <form action="" method="post">
                <h1>FORM ADD COMPANYIES</h1>
                <div class="contentform">
                    <div class="part1">
                    <label for="">Matricule</label>
                    <input type="text" placeholder="matricule" name="matricule">

                    <label for="">Nom</label>
                    <input type="text" placeholder="Nom" name="nom">

                    <label for="">Prenom</label>
                    <input type="text" placeholder="Prenom" name="prenom">

                    <label for="">phone</label>
                    <input type="text" placeholder="phone" name="phone">

                    <label for="">Ville</label>
                     <select name="ville" id="ville">
                        <option value="">Choose ville</option>
                        <?php
                            include 'conn.php';
                            $result = $conn->query("SELECT * FROM setting_villes");
                            while ($row = $result->fetch_assoc()) {       
                                echo "<option value='{$row['id']}'>{$row['ville']}</option>";
                            }
                        ?>
                    </select>


                  
                </div>
            

                <div class="part2">
                    <label for="">Email</label>
                    <input type="email" placeholder="Email" name="email">

                    <label for="">Categorie</label>
                  <select name="categorie" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="option1">option1</option>
                        <option value="option2">option2</option>
                    </select>


                    <label for="">Poste</label>
                    <input type="text" placeholder="poste" name="poste">

                    
                   <label for="zone">Zone</label>
                    <select name="zone" id="zone">
                        <option value="">Choose zone</option>
                    </select>


                </div>
            </div>

                <button type="submit">Add</button>
            </form>
        </div>
    </div>

<script>
// عند تغيير المدينة (ville)، نقوم بتحميل المناطق (zone)
document.getElementById('ville').addEventListener('change', function() {
    var villeId = this.value;

    // إذا كانت المدينة مختارة
    if (villeId) {
        // إرسال طلب AJAX إلى الخادم لتحميل المناطق بناءً على المدينة
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_zones.php?ville_id=' + villeId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var zones = JSON.parse(xhr.responseText);
                var zoneSelect = document.getElementById('zone');
                zoneSelect.innerHTML = '<option value="">Choose zone</option>'; // مسح الخيارات الحالية

                // إضافة الخيارات الجديدة للمناطق
                zones.forEach(function(zone) {
                    var option = document.createElement('option');
                    option.value = zone.zone_name;
                    option.textContent = zone.zone_name;
                    zoneSelect.appendChild(option);
                });
            }
        };
        xhr.send();
    }
});
</script>
    </body>
</html>