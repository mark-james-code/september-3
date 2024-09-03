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

// Fetch residents
$residents = [];
$residents_result = $conn->query("SELECT * FROM residents");
if ($residents_result->num_rows > 0) {
    while ($row = $residents_result->fetch_assoc()) {
        $residents[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/residents.css">
</head>
<body>
    <!-- Sidebar and Header -->
    <header class="dashboard-header">
        <div class="grid-header">
            <div><img src="img/logo.jpg" class="logo-header" alt=""></div>
            <div class="BDAMS"><p>Barangay Dalla Attendance Monitoring System</p></div>
            <div><i class='bx bx-bell bx-tada'></i></div>
        </div>
    </header>

    <div class="sidebar">
        <div class="top">
            <div class="logo"><p>Sidebar Menu</p></div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul>
            <li><a href="#"><i class='bx bxs-dashboard'></i><span class="nav-item">Dashboard</span></a><span class="tool-tip">Dashboard</span></li>
            <li><a href="#"><i class='bx bx-user-check'></i><span class="nav-item">Attendance</span></a><span class="tool-tip">Attendance</span></li>
            <li><a href="#"><i class='bx bxs-folder-open'></i><span class="nav-item">Records</span></a><span class="tool-tip">Records</span></li>
            <li><a href="residents.php"><i class='bx bx-list-ul'></i><span class="nav-item">Residents</span></a><span class="tool-tip">Residents</span></li>
            <li><a href="cleanup_drive.php"><i class='bx bx-trash'></i><span class="nav-item">Cleanup Drive</span></a><span class="tool-tip">Cleanup Drive</span></li>
            <li class="logout"><a href="#"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a><span class="tool-tip">Logout</span></li>
        </ul>
    </div>

    <!-- Residents Table -->
    <div class="container">
        <h2>Residents</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($residents as $resident): ?>
                    <tr>
                        <td><?= $resident['name']; ?></td>
                        <td><?= $resident['age']; ?></td>
                        <td><?= $resident['sex']; ?></td>
                        <td><?= $resident['zone']; ?></td>
                        <td><img src="<?= $resident['qr_code_url']; ?>" alt="QR Code"></td>
                        <td>
                            <button class="add-to-cleanup" data-id="<?= $resident['id']; ?>" data-name="<?= $resident['name']; ?>" data-age="<?= $resident['age']; ?>" data-sex="<?= $resident['sex']; ?>" data-zone="<?= $resident['zone']; ?>" data-qr="<?= $resident['qr_code_url']; ?>">Add to Cleanup Drive</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.add-to-cleanup').forEach(button => {
            button.addEventListener('click', function() {
                const formData = new FormData();
                formData.append('name', this.getAttribute('data-name'));
                formData.append('age', this.getAttribute('data-age'));
                formData.append('sex', this.getAttribute('data-sex'));
                formData.append('zone', this.getAttribute('data-zone'));
                formData.append('qrCodeUrl', this.getAttribute('data-qr'));

                fetch('cleanup_drive.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                      if (data.status === "success") {
                          alert("Resident added to Cleanup Drive");
                      } else {
                          alert("Error: " + data.message);
                      }
                  });
            });
        });
    </script>
</body>
</html>
