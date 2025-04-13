<?php
 if (session_status() === PHP_SESSION_NONE) {
           session_start();
    }
    include 'conn.php';


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$fistword = $_SESSION['username'];
$fistword = substr(trim($fistword),0,1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_menu.css?v=5">
     <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"rel="stylesheet"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <nav>
        <div class="links">
           <button class="dropmenu"><i class='bx bx-menu'></i></button>
          
        </div>
        <div class="logo">   
          <div class="admin">
              <h3><?php echo $_SESSION['username']; ?></h3>
            <p>Admin <button><i class='bx bx-caret-down-circle' ></i></button></p>
          </div>
            <div class="firstWorld">
                <span><?php echo $fistword; ?></span>
            </div>
        </div>

        
    </nav>
    <div class="menu">
        <div class="links_menu">
          
        <div class="logo">
            <h3>Service Miage</h3>
        </div>  
        <button class="dropmenuClose"><i class='bx bx-x'></i> </button>   
        </div>


        <div class="btnsMenu">
            <a href="dashboard.php"><i class='bx bxs-dashboard'></i>  <span>Dashboard</span></a>
            <a href="All_clients.php"><i class='bx bxs-user-detail'></i>  <span>Gestion Ecole</span></a>
            <a href="Company_management.php"><i class='bx bx-buildings'></i> <span>Gestion Entreprises</span></a>
            <a href="#"><i class='bx bxs-add-to-queue'></i>  <span>Vide</span></a>
            <a href="#"><i class='bx bxs-add-to-queue'></i>  <span>Vide</span></a>
            <a href="#"><i class='bx bxs-add-to-queue'></i>  <span>Vide</span></a>
          
        </div>

        <div class="btnlogout">
             <a href="settings.php"><i class='bx bx-cog'></i>  <span>Setting</span></a>
             <a href="index.php"><i class='bx bx-log-in'></i>  <span>Log Out</span></a>
        </div>
    </div>
</body>
<script>

    const dropmenu = document.querySelector('.dropmenu'),
     menu = document.querySelector('.menu'),
     dropmenuClose = document.querySelector('.dropmenuClose');


    dropmenuClose.addEventListener('click',()=>{
        menu.classList.remove('display');
    });

    dropmenu.addEventListener('click',()=>{
        menu.classList.add('display');
    });





</script>
</html>