<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdams_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions (add or delete users)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $userId = $_POST['userId'];
        $sql = "DELETE FROM cleanup_drive WHERE id=$userId";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        exit();
    }

    // Add new user
    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $zone = $_POST['zone'];
    $qrCodeUrl = $_POST['qrCodeUrl'];

    $sql = "INSERT INTO cleanup_drive (name, age, sex, zone, qr_code_url) VALUES ('$name', '$age', '$sex', '$zone', '$qrCodeUrl')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
    exit();
}

// Fetch cleanup drive users
$cleanup_users = [];
$result = $conn->query("SELECT * FROM cleanup_drive");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cleanup_users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleanup Drive</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/cd.css">
</head>
<body>
    <!-- Sidebar and Header -->
    <header class="dashboard-header">
        <div class="grid-header">
            <div><img src="img/logo.jpg" class="logo-header" alt=""></div>
            <div class="BDAMS"><p>Barangay Dalla Attendance Monitoring System Using QR Code</p></div>
            <div><i class='bx bxs-bell'></i></div>
        </div>
    </header>

    <div class="sidebar">
        <div class="top">
            <div class="logo"><p>Sidebar Menu</p></div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul>
            <li><a href="dashboard.html"><i class='bx bxs-dashboard'></i><span class="nav-item">Dashboard</span></a><span class="tool-tip">Dashboard</span></li>
            <li><a href="#"><i class='bx bx-user-check'></i><span class="nav-item">Attendance</span></a><span class="tool-tip">Attendance</span></li>
            <li><a href="#"><i class='bx bxs-folder-open'></i><span class="nav-item">Records</span></a><span class="tool-tip">Records</span></li>
            <li><a href="residents.php"><i class='bx bx-list-ul'></i><span class="nav-item">Residents</span></a><span class="tool-tip">Residents</span></li>
            <li class="logout"><a href="#"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a><span class="tool-tip">Logout</span></li>
        </ul>
    </div>

    <!-- Cleanup Drive Table -->
     <div class="arb" >
     <a href="resident.php" class="addresidents-button">Add Residents</a>

     </div>
    <div class="container-cd">
        <h2>Cleanup Drive</h2>
       
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cleanup_users as $user): ?>
                    <tr>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['age']; ?></td>
                        <td><?= $user['sex']; ?></td>
                        <td><?= $user['zone']; ?></td>
                        <td><img src="<?= $user['qr_code_url']; ?>" alt="QR Code"></td>
                        <td>
                            <button class="delete" onclick="deleteUser(<?= $user['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>

    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

         btn.onclick = function() {
          sidebar.classList.toggle('active');
         };

        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this resident?")) {
                const formData = new FormData();
                formData.append('userId', userId);
                formData.append('action', 'delete');
                fetch('cleanup_drive.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                      if (data.status === "success") {
                          location.reload();
                      } else {
                          alert("Error: " + data.message);
                      }
                  });
            }
        }
    </script>
</body>
</html>
