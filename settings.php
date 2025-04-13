<?php 
    include 'conn.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // إضافة Ville
    if (isset($_POST['add_ville'])) {
        $ville_name = $_POST['ville'];

        if (!empty(trim($ville_name))) {
            if (isset($_POST['ville_id']) && !empty($_POST['ville_id'])) {
                // تحديث
                $id = $_POST['ville_id'];
                $stmt = $conn->prepare('UPDATE `setting_villes` SET `ville` = ? WHERE id = ?');
                $stmt->bind_param('si', $ville_name, $id);
              
            } else {
              
                $stmt = $conn->prepare('INSERT INTO `setting_villes`(`ville`) VALUES (?)');
                $stmt->bind_param('s', $ville_name);   
              
            }

            $stmt->execute();
            $stmt->close();
        }

        // إعادة توجيه لتجنب إعادة الإرسال
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // إضافة Zone
    if (isset($_POST['add_zone'])) {
        if (isset($_POST['zone_input']) && isset($_POST['ville_id']) && !empty($_POST['zone_input']) && !empty($_POST['ville_id'])) {
            $zone = $_POST['zone_input'];
            $ville_id = $_POST['ville_id'];
        if (isset($_POST['zone_id']) && !empty($_POST['zone_id'])) {
            // تعديل
            $zone_id = $_POST['zone_id'];
            $stmt = $conn->prepare('UPDATE `setting_zones` SET `zone_name` = ?, `ville_id` = ? WHERE id = ?');
            $stmt->bind_param('sii', $zone, $ville_id, $zone_id);
        } else {
            // إضافة
            $stmt = $conn->prepare('INSERT INTO `setting_zones` (`zone_name`, `ville_id`) VALUES (?, ?)');
            $stmt->bind_param('si', $zone, $ville_id);
             
        }
                $stmt->execute();
                $stmt->close();
        }

        // إعادة توجيه لتجنب إعادة الإرسال
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="stylesheet" href="settings.css?v=4" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
</head>
    <body>
        <?php include 'menu.php'; ?>
        <div class="title">
            <h1>Form settings villes and zones</h1>
        </div>
        <div class="container">
            <div class="formvilles">
                 <div class="titleform">
                    <h3>FORM VILLE <i class='bx bxs-map'  ></i></h3>
                  </div>
               <form action="" method="post">
                    <label for="">Enter a ville </label>
                    <input type="text" placeholder="ville" name="ville" value="<?php if(isset($_GET['edit_ville'])) echo $_GET['edit_ville']; ?>">
                    <input type="hidden" name="ville_id" value="<?php if(isset($_GET['edit_id'])) echo $_GET['edit_id']; ?>">
                    <button type="submit" name="add_ville"><?php echo isset($_GET['edit_ville']) ? 'Update' : 'Add'; ?></button>
                </form>

               <div class="table">
                 <table>
                <tr>
                    <th>id</th>
                    <th>Ville</th>
                    <th>Option</th>
                </tr>
                <?php 
                    include 'conn.php';
                    $stmt = $conn->prepare('SELECT * FROM setting_villes');
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ville']; ?></td>
                   <td>
                        <a href="?edit_id=<?php echo $row['id']; ?>&edit_ville=<?php echo urlencode($row['ville']); ?>" class="update">
                           <i class='bx bx-upload'></i>
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="delete">
                           <i class='bx bx-x'></i>
                        </a>
                    </td>
                </tr>
                 <?php
                    }
                    $stmt->close();
                 ?>
                </table>
               </div>
            </div>

            <div class="formzones">
                  <div class="titleform">
                    <h3>FORM ZONE <i class='bx bx-current-location'  ></i></h3>
                  </div>
                <form action="" method="post">
                   
                     <label for="">Zone</label>
                    <select name="ville_id">
                        <option value="">shoose ville</option>
                       <?php
                            include 'conn.php';
                            $result = $conn->query("SELECT * FROM setting_villes");
                            while($row = $result->fetch_assoc()){
                                echo "<option value='{$row['id']}'>{$row['ville']}</option>";
                            }
                        ?>
                    </select>


                    <label for="">Enter a Zone </label>
                    <input type="text" placeholder="zone" name="zone_input" value="<?php if(isset($_GET['edit_zone'])) echo $_GET['edit_zone']; ?>">

                    <input type="hidden" name="zone_id" value="<?php if(isset($_GET['edit_zone_id'])) echo $_GET['edit_zone_id']; ?>">

                    <button type="submit" name="add_zone"><?php echo isset($_GET['edit_zone']) ? 'update' : 'Add'; ?></button>
                </form>
              <div class="table">
                  <table>
                <tr>
                    <th>id</th>
                    <th>Ville</th>
                    <th>zone</th>
                    <th>Option</th>
                </tr>
                <?php
                    include 'conn.php';
                    $whereClause = "";
                    $query = "SELECT setting_zones.id, setting_zones.zone_name, setting_zones.ville_id, setting_villes.ville 
                    FROM setting_zones
                    JOIN setting_villes ON setting_zones.ville_id = setting_villes.id";


                    $result = $conn->query($query);
                    while($row = $result->fetch_assoc()){

                    
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ville']; ?></td>
                    <td><?php echo $row['zone_name']; ?></td>
                    <td>
                    <a href="?edit_zone_id=<?php echo $row['id']; ?>&edit_zone=<?php echo urlencode($row['zone_name']); ?>&ville_id=<?php echo $row['ville_id']; ?>" class="update">
                        <i class='bx bx-upload'></i>
                    </a>

                        <a href="delete_zone.php?id=<?php echo $row['id']; ?>" onclick="return confirm('هل أنت متأكد من الحذف؟');" class="delete">
                        <i class='bx bx-x'></i>
                        </a>
                    </td>
                </tr>
                 <?php 
                    }
                 ?>
                </table>
              </div>
            </div>
        </div>

    </body>
</html>