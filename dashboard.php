

<?php
  include 'conn.php';
  $stmt = $conn->prepare('SELECT COUNT(id_client) AS totalClient FROM `db_client`');
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $totalClient = $row['totalClient'];

?>

<?php
  include 'conn.php';
  $stmt = $conn->prepare('SELECT COUNT(id_client) AS totalClientAcc FROM `db_client` where `status` = 1');
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $totalClientAcc = $row['totalClientAcc'];

?>

<?php
  include 'conn.php';
  $stmt = $conn->prepare('SELECT COUNT(id_client) AS totalClientUnacc FROM `db_client` where `status` != 0 and `status` != 1');
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $totalClientUnacc = $row['totalClientUnacc'];

?>
<?php
  include 'conn.php';
  $stmt = $conn->prepare('SELECT COUNT(id_client) AS totalClientComming FROM `db_client` where `status` = 0');
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $totalClientComming = $row['totalClientComming'];

?>


<?php
  include 'conn.php';
  $dataChart = $conn->prepare("SELECT DATE_FORMAT(`dateCreated`, '%M') AS months,
 count(id_client) AS client from `db_client` GROUP BY months order by client DESC");
 $dataChart->execute();
 $result = $dataChart->get_result();
 $Total_client = [];
 $Total_months = [];

while ($row = $result->fetch_assoc()) {
    $Total_client[] = $row['client'];   
    $Total_months[] = $row['months']; 
}

 $dataChart->close();
 $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="dashStyle.css?v=7" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dahboard Home</title>
  </head>
  <body>
 <?php  include 'menu.php'; ?>
 <div class="container">
    <div class="boxes">
      <div class="box" id="bx1">
        <div class="statics">
          <h2>All Clients</h2>
          <span><?php echo $totalClient; ?> <i class='bx bx-trending-up' style='color:rgb(22, 179, 22);' ></i></span>
        </div>
        <div class="icon">
        <i class='bx bxs-user' id="case_Allusers" ></i>
        </div>
      </div>

       <div class="box" id="bx2">
        <div class="statics">
          <h2>Clients Accepted</h2>
          <span><?php  echo $totalClientAcc ;?> 
             <?php 
            if($totalClientAcc > $totalClientUnacc){
               echo " <i class='bx bx-trending-up' style='color:rgb(22, 179, 22);' ></i>";
            }else{
              echo "<i class='bx bx-trending-down' style='color:rgb(179, 22, 22);' ></i>";
            }
          ?>
        </span>
        </div>
        <div class="icon">
         <i class='bx bxs-user-check' id="case_Accusers" ></i>
        </div>
      </div>

       <div class="box" id="bx3">
        <div class="statics">
          <h2>Clients Unaccepted</h2>
          <span><?php echo $totalClientUnacc; ?>
          <?php 
            if($totalClientAcc > $totalClientUnacc){
               echo " <i class='bx bx-trending-up' style='color:rgb(22, 179, 22);' ></i>";
            }else{
              echo "<i class='bx bx-trending-down' style='color:rgb(179, 22, 22);' ></i>";
            }
          ?>
        
        
        </span>
        </div>
        <div class="icon">
         <i class='bx bxs-user-x' id="case_UnAccusers" ></i>
        </div>
      </div>

      <div class="box" id="bx4">
        <div class="statics">
          <h2>Clients Comming</h2>
          <span><?php echo $totalClientComming; ?>
             <?php 
            if($totalClientComming < $totalClientAcc){
               echo " <i class='bx bx-trending-up' style='color:rgb(22, 179, 22);' ></i>";
            }else{
              echo "<i class='bx bx-trending-down' style='color:rgb(179, 22, 22);' ></i>";
            }
          ?>
        </span>
        </div>
        <div class="icon">
          <i class='bx bxs-hourglass-bottom' id="case_Commusers" ></i>
        </div>
      </div>
    </div>


    <div class="charts">
      <div class="chart01">
         <canvas id="myChart"></canvas>
      </div>
      <div class="chart01">
         <canvas id="myChart2"></canvas>
      </div>
    </div>
 </div>
  
    <script src="dashjs.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const Total_months = <?php echo json_encode($Total_months) ?>;
  const Total_clients = <?php echo json_encode($Total_client) ?>; 
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'line',
    data: {

      labels: Total_months ,
      datasets: [{
        label: '# of Votes',
        data: Total_clients,
        
        backgroundColor : ['green'],
        borderWidth: 2,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });



  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Client Accepted', 'Client Unaccepted'],
      datasets: [{
        label: '',
        data: [<?php echo $totalClientUnacc;  ?>,<?php echo $totalClientAcc; ?>],
        borderWidth: 1,
         backgroundColor: ['rgb(255, 117, 117)', 'rgb(120, 255, 110)'] // Bar colors
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
  </body>
</html>
