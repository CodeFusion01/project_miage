<?php
session_start();
include 'conn.php';

$error = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['usernameLogin']);
    $pass = trim($_POST['passwordLogin']);

    $stmt = $conn->prepare("SELECT `ID_account`, `password` FROM `account` WHERE `username` = ?");
    
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

   
        if (!empty($pass) && $pass === $password) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css?v=7" />
    <link rel="icon" href="logomiage.png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Service Miage</title>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="logomiage.png">
            <h3>Service Miage</h3>
        </div>

        <div class="links">
            <button><i class='bx bx-support'></i></button>
        </div>
    </nav>
             <?php if (!empty($error)): ?>
                    <div class="error" id="errorBox">
                        <div class="messageError">
                           <i class='bx bx-info-circle'></i> <?php echo $error; ?>
                        </div>    
                        <div class="btncloseError">
                            <button class="closeErrorBtn"><i class='bx bx-x'></i></button>
                        </div>
                    </div>
                <?php endif; ?>    
    <div class="container">
        
        <div class="img">
         
            <img src="imglogin.png" alt="" />
        </div>

        <form action="" method="POST">
              
            <div class="formLogin">
            
                <div class="title">
             
                    <h1>Service Miage<br><p>Login admin for managing the Clients</p></h1>
                </div>
                <label for="userN">Username</label>
                <div class="inputgroupe">
                    <input type="text" id="userN" placeholder="Enter a username ..." name="usernameLogin"/>
                </div>

                <label for="">Password</label>
                <div class="inputgroupe">
                    <input type="password" placeholder="Enter a password ..." name="passwordLogin" class="inputpass" >
                    <i class="bx bx-low-vision show"></i>
                </div>



                <button>Login</button>
            </div>
        </form>
    </div>

    <script src="app.js"></script>
<script>

    const errorBox = document.getElementById("errorBox"),
          closeError = document.querySelector(".closeErrorBtn"); 

    if (errorBox) {

        setTimeout(() => {
            errorBox.classList.add("show"); 
        }, 100); 

       
        if (closeError) {
            closeError.addEventListener("click", function () {
                errorBox.classList.remove("show"); 
            });
        }
    }



</script>

</body>
</html>
