<?php
session_start();
include 'connect.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user applications from the database
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM applications WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #007bff;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: block;
            margin-bottom: 10px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            padding: 20px;
            margin-left: 250px;  /* Sidebar width */
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar">
        <h2>User Dashboard</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="apply.php"><i class="fas fa-file-alt"></i> Apply</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="notifications.php"><i class="fas fa-bell"></i> Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="resources.php"><i class="fas fa-book"></i> Resources</a>
            </li>
        </ul>
    </div>
    
    <div class="content flex-grow-1">
        <h1 class="mb-4">Dashboard</h1>
        <p class="lead">Manage your bursary applications easily!</p>
        
        <p class="lead">Bursary applications provide financial support to students, enabling them to pursue their academic goals without the burden of financial stress. It's essential to stay updated on your application status and take advantage of new opportunities!</p>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profile</h5>
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Applications</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bursary Name</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($applications->num_rows > 0): ?>
                                    <?php while ($application = $applications->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($application['bursary_name']); ?></td>
                                        <td>
                                            <span class="badge <?= 
                                                ($application['status'] == 'Approved' ? 'badge-success' : 
                                                 ($application['status'] == 'Rejected' ? 'badge-danger' : 'badge-warning')); ?>">
                                                <?= htmlspecialchars($application['status']); ?>
                                            </span>
                                        </td>
                                        <td><a href="view_applications.php?id=<?= $application['id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No applications found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="apply.php" class="btn btn-primary">Apply for New Bursary</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Notifications</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    // Sample notifications (replace with actual data from the database)
                    $notifications = [
                        "Your application for Bursary A has been approved!",
                        "New bursary opportunities available. Check them out!",
                    ];
                    foreach ($notifications as $notification): ?>
                    <li class="list-group-item notification-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <?= htmlspecialchars($notification); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 Imenti North Bursary Application Portal. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>