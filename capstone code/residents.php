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

// Add, update, or delete user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $userId = $_POST['userId'];
        $sql = "DELETE FROM residents WHERE id=$userId";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        exit();
    }

    $name = $_POST['name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $zone = $_POST['zone'];
    $qrCodeUrl = $_POST['qrCodeUrl']; 

    if (isset($_POST['userId']) && $_POST['userId'] != "") {
        // Update existing user
        $userId = $_POST['userId'];
        $sql = "UPDATE residents SET name='$name', age='$age', sex='$sex', zone='$zone', qr_code_url='$qrCodeUrl' WHERE id=$userId";
    } else {
        // Insert new user
        $sql = "INSERT INTO residents (name, age, sex, zone, qr_code_url) VALUES ('$name', '$age', '$sex', '$zone', '$qrCodeUrl')";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
    exit();
}

// Fetch users for display in the table
$users = [];
$result = $conn->query("SELECT * FROM residents");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/residents.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<body>
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
            <li><a href="dashboard.html"><i class='bx bxs-dashboard'></i><span class="nav-item">Dashboard</span></a><span class="tool-tip">Dashboard</span></li>
            <li><a href="#"><i class='bx bx-user-check'></i><span class="nav-item">Attendance</span></a><span class="tool-tip">Attendance</span></li>
            <li><a href="#"><i class='bx bxs-folder-open'></i><span class="nav-item">Records</span></a><span class="tool-tip">Records</span></li>
            <li><a href="#"><i class='bx bx-list-ul'></i><span class="nav-item">Residents</span></a><span class="tool-tip">Residents</span></li>
            <li class="logout"><a href="#"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a><span class="tool-tip">Logout</span></li>
        </ul>
    </div>

    <div class="addtable">
        <div class="table-fixed">
            <h1>Adding Residents Information with QR Code</h1>
            <form id="userForm">
                <input type="hidden" id="userId" name="userId">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Zone</th>
                        <th>QR Code</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <td><input type="text" id="name" name="name" placeholder="Enter Name" required></td>
                        <td><input type="number" id="age" name="age" placeholder="Enter Age" required></td>
                        <td>
                            <select id="sex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </td>
                        <td><input type="text" id="zone" name="zone" placeholder="Enter Zone" required></td>
                        <td class="qr-code">
                            <img id="qrCodeImage" src="https://via.placeholder.com/100" alt="QR Code">
                            <input type="hidden" id="qrCodeUrl" name="qrCodeUrl">
                        </td>
                        <td><button type="button" class="button" id="addBtn">Add Resident</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Added Residents</h2>
        <table id="userTable">
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
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['age']; ?></td>
                        <td><?= $user['sex']; ?></td>
                        <td><?= $user['zone']; ?></td>
                        <td>
                            <img src="<?= $user['qr_code_url']; ?>" alt="QR Code">
                            <a href="<?= $user['qr_code_url']; ?>" download="QRCode_<?= $user['name']; ?>.png">Download</a>
                        </td>
                        <td class="action-buttons">
                            <button onclick="editUser(<?= $user['id']; ?>, '<?= $user['name']; ?>', <?= $user['age']; ?>, '<?= $user['sex']; ?>', '<?= $user['zone']; ?>', '<?= $user['qr_code_url']; ?>')">Edit</button>
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

        btn.onclick = function () {
            sidebar.classList.toggle('active');
        };

        function generateQRCode() {
            const name = document.getElementById("name").value;
            const zone = document.getElementById("zone").value;
            const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${encodeURIComponent(`Name: ${name}, Zone: ${zone}`)}`;
            document.getElementById("qrCodeImage").src = qrCodeUrl;
            document.getElementById("qrCodeUrl").value = qrCodeUrl;
        }

        document.getElementById("name").addEventListener("input", generateQRCode);
        document.getElementById("zone").addEventListener("input", generateQRCode);

        document.getElementById("addBtn").addEventListener("click", function (e) {
            e.preventDefault();
            const formData = new FormData(document.getElementById("userForm"));
            fetch('', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if (data.status === "success") {
                      location.reload(); // Refresh the page to see the updated residents
                  } else {
                      alert("Error: " + data.message);
                  }
              });
        });

        function editUser(id, name, age, sex, zone, qrCodeUrl) {
            document.getElementById('userId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('age').value = age;
            document.getElementById('sex').value = sex;
            document.getElementById('zone').value = zone;
            document.getElementById('qrCodeImage').src = qrCodeUrl;
            document.getElementById('qrCodeUrl').value = qrCodeUrl;
        }

        function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this resident?")) {
                const formData = new FormData();
                formData.append('userId', userId);
                formData.append('action', 'delete');
                fetch('', {
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
