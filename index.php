<?php
$servername = "localhost";
$username = "root"; // Your DB username
$password = "";     // Your DB password
$dbname = "risk";   // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
require_once('db.php');
if(!isset($_SESSION["loggedin"]) ){
  header("location:login.php");
}

// Function to categorize risk
function categorizeRisk($risk_score) {
    if ($risk_score >= 25) {
        return 'Critical';
    } elseif ($risk_score >= 16) {
        return 'High';
    } elseif ($risk_score >= 6) {
        return 'Medium';
    } else {
        return 'Low';
    }
}

// Initialize category counters
$counts = ['Critical' => 0, 'High' => 0, 'Medium' => 0, 'Low' => 0];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $risk_name = mysqli_real_escape_string($conn, $_POST['risk_name']);
    $risk_description = mysqli_real_escape_string($conn, $_POST['risk_description']);
    $risk_impact = intval($_POST['risk_impact']);
    $risk_likelihood = intval($_POST['risk_likelihood']);
    $risk_score = $risk_impact * $risk_likelihood;
    $controls = mysqli_real_escape_string($conn, $_POST['controls']);
    $Inherent_Impact = intval($_POST['Inherent_Impact']);
    $inherent_Likelihood = intval($_POST['inherent_Likelihood']);
    $Inherent_Risk = $Inherent_Impact * $inherent_Likelihood;
    $Owner = mysqli_real_escape_string($conn, $_POST['Owner']);

    
   
   
    
   
    
   
    $sql = "INSERT INTO risk_register (risk_name, risk_description, risk_impact, risk_likelihood, risk_score,controls,Inherent_Risk,Owner,Inherent_Impact,inherent_Likelihood) 
            VALUES ('$risk_name', '$risk_description', '$risk_impact', '$risk_likelihood','$risk_score','$controls','$Inherent_Risk','$Owner','$Inherent_Impact','$inherent_Likelihood')";

    if ($conn->query($sql) === TRUE) {
        echo "<div id='alertBox' div class='alert alert-success'>New risk added successfully</div>";
    } else {
        echo "<div id='alertBox' div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$sql = "SELECT * FROM risk_register";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category = categorizeRisk($row["risk_score"]);
        $counts[$category]++;
    }
}

// Rewind the result set
$result->data_seek(0);

$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';

$sql = "SELECT * FROM risk_register";
if (!empty($filter_category)) {
    $filter_category = mysqli_real_escape_string($conn, $filter_category);
    $sql .= " WHERE risk_score " . ($filter_category == 'Low' ? "<= 5" : ($filter_category == 'Medium' ? "BETWEEN 6 AND 15" : ($filter_category == 'High' ? "BETWEEN 16 AND 24" : ">= 25")));
}



$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
    <style>
        body {
        margin: 0;

            padding: 0px;
            background-color: #c6d5f9;
             font-family: 'Lato', sans-serif;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
        }
        .risk-category {
            font-weight: bold;
        }
        .risk-category.Low { color: green; }
        .risk-category.Medium { color: goldenrod; }
        .risk-category.High { color: darkorange; }
        .risk-category.Critical { color: red; }
        .header {
            margin-bottom: 30px;
            text-align: center;
        }
        .btn-load-chart {
            margin-bottom: 20px;
        }
        .dashboard {
            display: flex;
            justify-content: space-between;
        }
        .dashboard > div {
            flex: 1;
            padding: 10px;
            margin: 5px;
            text-align: center;
            color: #fff;
            border-radius: 10px;
            font-weight: bold;
        }
        .dashboard .total { background-color: #007bff; }
        .dashboard .critical { background-color: #dc3545; }
        .dashboard .high { background-color: #FF9800; }
        .dashboard .medium{ background-color: #FFC107; }
        .dashboard .low { background-color: #8BC34A; }
        .form-section {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-section h2 {
            margin-bottom: 15px;
        }
        .table-section {
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 10px;
        }
        .table-section h2 {
            margin-bottom: 15px;
        }
        .filter-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 0px 5px;
            border-radius: 10px;
            background-color: #007BFF;
            transition: background-color 0.3s;
        }
        .filter-links a:hover {
            background-color: #003d7a;
        }
        .custom-bg-color {
    background-color: #1c2230; 
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-bg-color sticky-top">

        
    <a class="navbar-brand mb-0 h1">Welcome <?php echo $_SESSION["username"]; ?> !</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav  ml-auto">
                
            <li class="nav-item ">
                    <a class="nav-link" href="users.php">Users</a>
                </li>   
             
            <li class="nav-item ">
            <a class="btn btn-outline-danger"type="button" href="#" data-toggle="modal" data-target="#Logout">Logout</a>
             
                </li>
                
            </ul>
            
        </div>
    </nav>
</nav>

</nav>


<div class="modal fade" id="Logout" tabindex="-1" aria-labelledby="Logout" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Logout">Logout Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout??</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <form action="logout.php" method="post"><button type="submit" class="btn btn-outline-danger">Logout</button></form>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>


    <!-- Dashboard -->
    <div class="dashboard">
        <div class="total">
            <div>Total Risks</div>
            <div><?php echo array_sum($counts); ?></div>
        </div>
        <div class="critical">
            <div>Critical Risks</div>
            <div><?php echo $counts['Critical']; ?></div>
        </div>
        <div class="high">
            <div>High Risks</div>
            <div><?php echo $counts['High']; ?></div>
        </div>
        <div class="medium">
            <div>Medium Risks</div>
            <div><?php echo $counts['Medium']; ?></div>
        </div>
        
        <div class="low">
            <div>Low Risks</div>
            <div><?php echo $counts['Low']; ?></div>
        </div>
    </div>

    <!-- Risk Register Form -->
    
    <div class="container-fluid mt-4">
        <div class="row">
        <div class="col-md-4"> 
        <h2>Add New Risk</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="risk_name">Risk Name:</label>
                <input type="text" class="form-control" id="risk_name" name="risk_name" required>
            </div>
            <div class="form-group">
                <label for="risk_description">Risk Description:</label>
                <textarea class="form-control" id="risk_description" name="risk_description" required></textarea>
            </div>

            <div class="form-group">
                <label for="Inherent_Impact">Inherent Risk Impact (1-5):</label>
                <input type="number" class="form-control" id="Inherent_Impact" name="Inherent_Impact" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="inherent_Likelihood">Inherent Risk Likelihood (1-5):</label>
                <input type="number" class="form-control" id="inherent_Likelihood" name="inherent_Likelihood" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="controls">Controls:</label>
                <textarea class="form-control" id="controls" name="controls" required></textarea>
            </div>

            <div class="form-group">
                <label for="risk_impact">Risk Impact (1-5):</label>
                <input type="number" class="form-control" id="risk_impact" name="risk_impact" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="risk_likelihood">Risk Likelihood (1-5):</label>
                <input type="number" class="form-control" id="risk_likelihood" name="risk_likelihood" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="Owner">Owner:</label>
                <input type="text" class="form-control" id="Owner" name="Owner" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Risk</button>
        </form>
    </div>

    <!-- Risk List -->
    
    <div class="col-md-8">
       <!-- load heat map button -->
    
    <div class="mb-3">
                    <button id="loadHeatMap" button class="btn btn-primary">Load Risk Heat Map</button>
                </div>
      <i class="fas fa-info-circle"></i><a href="#" data-toggle="modal" data-target="#infoModal">
  Info on Risk Matrix
</a>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Risk Matrix</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="risk-matrix.png" class="img-fluid" alt="Responsive image">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Filter Links -->
<div class="filter-links">
    <h3>Filter Risks:</h3>
    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">All</a> |
    <a href="?filter_category=Low">Low</a> |
    <a href="?filter_category=Medium">Medium</a> |
    <a href="?filter_category=High">High</a> |
    <a href="?filter_category=Critical">Critical</a>

    <a href="generate_pdf.php" class="btn btn-primary">Download PDF</a>
</div>

    <div class="table-section">
        <h2>Risk List</h2>
        <div class="scrollable-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Risk Name</th>
                        <th>Description</th>
                        <th>Inherent imapact</th>
                        <th>Inherent likelihood</th>
                        <th>Inherent risk</th>
                        <th>Controls</th>
                        <th>Impact</th>
                        <th>Likelihood</th>
                        <th>Residual risk</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Owner</th>

                        

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["risk_name"] . "</td>";
                            echo "<td>" . $row["risk_description"] . "</td>";
                            echo "<td>" . $row["Inherent_Impact"] . "</td>";
                            echo "<td>" . $row["inherent_Likelihood"] . "</td>";
                            echo "<td>" . $row["Inherent_Risk"] . "</td>";
                            echo "<td>" . $row["Controls"] . "</td>";

                            echo "<td>" . $row["risk_impact"] . "</td>";
                            echo "<td>" . $row["risk_likelihood"] . "</td>";
                            echo "<td>" . $row["risk_score"] . "</td>";

                            echo "<td class='risk-category " . categorizeRisk($row["risk_score"]) . "'>" . categorizeRisk($row["risk_score"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                         
                            echo "<td>" . $row["Owner"] . "</td>";
                            echo "<td><form action='delete_risk.php' method='post'><input type='hidden' name='risk_id' value='" . $row["id"] . "'><button type='submit' class='btn btn-danger'>Delete</button></form></td>";
                           

                            echo "<td><form action='update.php' method='post'><input type='hidden' name='update_risk_id' value='" . $row["id"] . "'><button type='submit' class='btn btn-success'>Update</button></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No risks recorded</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

 <!-- Modal -->
<div class="modal fade" id="riskHeatMapModal" tabindex="-1" role="dialog" aria-labelledby="riskHeatMapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riskHeatMapModalLabel">Risk Heat Map</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <canvas id="riskHeatMap"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Heat Map Canvas -->
<div>
    <canvas id="riskHeatMap"></canvas>
</div>

<!-- JavaScript Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var myChart = null;

    document.getElementById('loadHeatMap').addEventListener('click', function() {
    // Send AJAX request to PHP script
    fetch('getRiskData.php') //  path to PHP script
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('riskHeatMap').getContext('2d');

                // Prepare datasets
                var datasets = {
                    'Critical': { data: [], backgroundColor: 'rgba(255, 99, 132, 0.5)' },
                    'High': { data: [], backgroundColor: 'rgba(255, 206, 86, 0.5)' },
                    'Medium': { data: [], backgroundColor: 'rgba(75, 192, 192, 0.5)' },
                    'Low': { data: [], backgroundColor: 'rgba(54, 162, 235, 0.5)' }
                };

                // Process data
                data.forEach(item => {
                    var offsetX = Math.random() * 0.8 - 0.4; 
                    var offsetY = Math.random() * 0.8 - 0.4; 
                    datasets[item.category].data.push({
                        riskName: item.risk_name,
                        x: parseInt(item.likelihood) + offsetX,
                        y: parseInt(item.impact) + offsetY,
                        r: 5, // Radius of the dots
                       
                    });
                });

                var chartData = Object.keys(datasets).map(key => ({
                    label: key,
                    data: datasets[key].data,
                    backgroundColor: datasets[key].backgroundColor
                }));

                // If a chart instance exists, destroy it before creating a new one
                if (myChart) {
                    myChart.destroy();
                }

                myChart = new Chart(ctx, {
                    type: 'bubble',
                    data: { datasets: chartData },
                    options: {
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Likelihood'
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Impact'
                                },
                                ticks: {
                                    beginAtZero: true
                                }
                                
                            }]

                            
                        },
                        title: {
                            display: true,
                            text: 'Risk Heat Map'
                        },
                        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    var value = tooltipItem.value;
                    var riskName = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].riskName;
                    return datasetLabel + ': (' + riskName + ') ' ;
                }
            }
        }
    

                    }
                    
                });
                $('#riskHeatMapModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
            
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Check if the alert box exists
    if (document.getElementById("alertBox")) {
        setTimeout(function() {
            // Hide the alert box after 3 seconds
            document.getElementById("alertBox").style.display = 'none';
        }, 1000);
    }
</script>

</body>
</html>
<?php
$conn->close();
?>
