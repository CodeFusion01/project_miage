<?php
include 'conn.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_client"])) {
    $id = intval($_POST["id_client"]);

    if (isset($_POST["whaiting"])) {
        $status = 0;  // Waiting
    } elseif (isset($_POST["accepting"])) {
        $status = 1; 
    } elseif (isset($_POST["unaccepted"])) {
        $status = 2;  
    }

    $stmt = $conn->prepare("UPDATE `db_client` SET `status` = ? WHERE `id_client` = ?");
    $stmt->bind_param("ii", $status, $id);
    $stmt->execute();
    $stmt->close();

    
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$search = isset($_GET["searchinput"]) ? trim($_GET["searchinput"]) : "";

$sql = "SELECT * FROM `db_client` WHERE 1"; 


   

if (!empty($search)) {
    $sql .= " AND (`nom` LIKE ? OR `prenom` LIKE ? OR `gmail` LIKE ?)";
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$ville = isset($_GET['ville']) ? $_GET['ville'] : '';
$poste = isset($_GET['poste']) ? $_GET['poste'] : '';
$status_filter = isset($_GET['status']) ? intval($_GET['status']) : ''; 
if (!empty($category)) {
    $sql .= " AND categorie = ?";
}
if (!empty($ville)) {
    $sql .= " AND ville = ?";
}
if (!empty($poste)) {
    $sql .= " AND poste = ?";
}
if ($status_filter !== '') {  
    $sql .= " AND `status` = ?";
}

$stmt = $conn->prepare($sql);


$param_types = "";
$params = [];

if (!empty($search)) {
    $search_param = "%" . $search . "%";
    $param_types .= "sss";
    $params[] = &$search_param;
    $params[] = &$search_param;
    $params[] = &$search_param;
}

if (!empty($category)) {
    $param_types .= "s";
    $params[] = &$category;
}

if (!empty($ville)) {
    $param_types .= "s";
    $params[] = &$ville;
}

if (!empty($poste)) {
    $param_types .= "s";
    $params[] = &$poste;
}
if ($status_filter !== '') {  // If status filter is provided
    $param_types .= "i";
    $params[] = &$status_filter;
}

if (!empty($param_types)) {
    $stmt->bind_param($param_types, ...$params);
}


$ville_sql = "SELECT DISTINCT `ville` FROM `db_client`";
$ville_result = $conn->query($ville_sql);

$post_sql = "SELECT DISTINCT `poste` FROM `db_client`";
$post_result = $conn->query($post_sql);

$status_sql = "SELECT DISTINCT `status` FROM `db_client` WHERE `status` IN (0, 1, 2)";
$status_result = $conn->query($status_sql);


$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="stylesheet" href="all_client.css?v=16" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Clients</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="navTable"> 
        <div class="typeDash"> 
         
            <a href="data-entery.php"> <button><i class='bx bxs-user-plus'></i>Add</button></a>   
            <h4>Dashboard Gestion Ecole</h4>
        </div>


            <div class="filters">
                <button class="btnDropAll" onclick="clearFilters()"><i class='bx bx-filter-alt'></i>All</button>
                <div class="filter">
                    <button class="btnDrop"><i class='bx bx-filter-alt'></i> Categories <i class='bx bx-chevron-down'></i></button>

                   
                         <form method="GET" action="">
                             <div class="catdrop">
                            <button type="submit" name="category" value="Ecole">Ecole</button>
                            <button type="submit" name="category" value="Ecole superieure">Ecole superieure</button>
                            <button type="submit" name="category" value="Enseignment">Enseignment</button>
                            <button type="submit" name="category" value="Persone">Persone</button>
                            <button type="submit" name="category" value="Entreprise">Entreprise</button>
                            <button type="submit" name="category" value="Industre">Industre</button>  
                        </div>
                        </form>
                  
                </div>

                     <div class="filter">
                    <button class="btnDrop2"><i class='bx bx-filter-alt'></i> Villes <i class='bx bx-chevron-down'></i></button>
                   
                        <form method="GET" action=""> 
                            
                            <div class="catdrop2">
                            <?php while($row = $ville_result->fetch_assoc()){ ?>
                            <button type="submit" name="ville" value="<?php echo $row['ville'] ?>"><?php echo ucfirst($row['ville']);  ?></button>
                            <?php } ;?>
                             </div>
                        </form>
                  
                </div>


                <div class="filter">
                    <button class="btnDrop3"><i class='bx bx-filter-alt'></i> Postes <i class='bx bx-chevron-down'></i></button>
                  
                        <form method="GET" action="">  
                            <div class="catdrop3">
                            <?php while($row_poste = $post_result->fetch_assoc()){ ?>
                            <button type="submit" name="poste" value="<?php echo $row_poste['poste'] ?>"><?php echo ucfirst($row_poste['poste']);  ?></button>
                            <?php } ;?>
                              </div>
                        </form>
                  
                </div>

                 <div class="filter">
                    <button class="btnDrop4"><i class='bx bx-filter-alt'></i> Staut <i class='bx bx-chevron-down'></i></button>
                  
                        <form method="GET" action="">  
                            <div class="catdrop4">
                            <?php while($row_status = $status_result->fetch_assoc()){ 
                                if ($row_status['status'] == 1){
                                    $status = "Accepted";
                                }elseif($row_status['status'] == 0){
                                    $status = "Waiting";
                                }else{
                                    $status = "Unaccepted";
                                }
                                ?>
                            <button type="submit" name="status" value="<?php echo $row_status['status'] ?>"><?php echo ucfirst($status); ?></button>
                            <?php } ;?>
                              </div>
                        </form>          
                </div>
            </div>

            <form method="get" class="search">         
                    <input type="text" name="searchinput" value="<?= htmlspecialchars($search) ?>"  placeholder="Wnter what do you want ...">
                    <button type="submit"><i class='bx bx-search-alt-2'></i></button>             
            </form>
        </div>
        <div class="Table">
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>prenom</th>
                    <th>nom</th>
                    <th>Ville</th>
                    <th>Categoris</th>
                    <th>Poste</th>
                    <th>Phone</th>
                     <th>Email</th>
                    <th>M</th>
                    <th>P</th>
                    <th>C</th>
                    <th>L</th>
                    <th>Staut</th>  
                    <th>Created by</th>
                    <th>Option</th>
                    <th>Option</th>
                </tr>
<?php while ($row = $result->fetch_assoc()) :?>
        <tr>
            <td><?= $row['id_client'] ?></td>
            <td><?= $row['nom'] ?></td>
            <td><?= $row['prenom'] ?></td>
            <td><?= $row['ville'] ?></td>
            <td><?= $row['categorie'] ?></td>
            <td><?= $row['poste'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['gmail'] ?></td>
          
                <td><input type="checkbox" <?= $row['marternelle'] == 1 ? 'checked' : " " ?>></td>
                <td><input type="checkbox" <?= $row['primaire'] == 1 ? 'checked'  : " " ?>></td>
                <td><input type="checkbox" <?= $row['college'] == 1 ? 'checked'  : " " ?>></td>
                <td><input type="checkbox" <?= $row['lycee'] == 1 ? 'checked' : " " ?>></td>
        
          
            <td>
                <?php
                if ($row['status'] == 0) {
                    echo "<span class='comm'>Waiting</span>";
                } elseif ($row['status'] == 1) {
                    echo "<span class='acc'>Accepted</span>";
                } else {
                    echo "<span class='unacc'>Not Accepted</span>";
                }
                ?>
            </td>
            <td class="creatdName"><span>Creatd by</span><?php echo $row['created_by']; ?></td>
            //? modification number:2
            <td><a href="updateUsers.php?id_client=<?php echo $row['id_client']; ?>"><i class='bx bx-edit'></i></a></td>

            <td>
                <form method="POST">
                    <input type="hidden" name="id_client" value="<?= $row['id_client'] ?>">
                    <button type="submit" name="whaiting" class="whaiting"><i class='bx bxs-stopwatch'></i></button>
                    <button type="submit" name="accepting" class="accepting"><i class='bx bxs-user-check'></i></button>
                    <button type="submit" name="unaccepted" class="unaccepted"><i class='bx bxs-user-x'></i></button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
       
            </table>

        </div>
    </div>
    <script>
        const btnDrop = document.querySelector('.btnDrop'),
        catdrop = document.querySelector('.catdrop');
        btnDrop.addEventListener('click',()=>{
            catdrop.classList.toggle('show');
            catdrop2.classList.remove('show');
            catdrop3.classList.remove('show');
            catdrop4.classList.remove('show');
            
        });

        const btnDrop2 = document.querySelector('.btnDrop2'),
        catdrop2 = document.querySelector('.catdrop2');   
        btnDrop2.addEventListener('click',()=>{
            catdrop2.classList.toggle('show');
            catdrop.classList.remove('show');
            catdrop3.classList.remove('show');
            catdrop4.classList.remove('show');
        });
   

     

        const btnDrop3 = document.querySelector('.btnDrop3'),
        catdrop3 = document.querySelector('.catdrop3');
        btnDrop3.addEventListener('click',()=>{
            catdrop3.classList.toggle('show');
            catdrop.classList.remove('show');
            catdrop2.classList.remove('show');
            catdrop4.classList.remove('show');
        });

        const btnDrop4 = document.querySelector('.btnDrop4'),
        catdrop4 = document.querySelector('.catdrop4');
        btnDrop4.addEventListener('click',()=>{
            catdrop4.classList.toggle('show');
            catdrop3.classList.remove('show');
            catdrop2.classList.remove('show');
             catdrop.classList.remove('show');
        });

        
      
     function clearFilters() {
    window.location.href = window.location.pathname;
}

  </script>
</body>
</html>
