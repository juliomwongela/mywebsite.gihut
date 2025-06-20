<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin login.php"); // Ensure this points to your login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bursary Applications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #007bff;
            padding: 20px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: white;
            padding: 10px;
            transition: background-color 0.3s;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            padding: 20px;
            flex-grow: 1;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .badge {
            font-size: 0.9em;
        }
        .notification-item {
            display: flex;
            align-items: center;
        }
        .notification-item i {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="admin dashboard 1.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_applications.php"><i class="fas fa-file-alt"></i> Manage Applications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage users.php"><i class="fas fa-users"></i> Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="notifications.php"><i class="fas fa-bell"></i> Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
        </ul>
    </div>
    
    <div class="content">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']); ?></h1>
        <p>Manage the bursary applications efficiently!</p>

        <!-- Applications Overview -->
        <div class="card">
            <div class="card-header">
                <h5>Applications Overview</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Bursary Name</th>
                            <th>Applicant Name</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Sample data array for demonstration (replace this with your actual database query)
                        $applications = [
                            ['id' => 1, 'bursary_name' => 'Bursary 1', 'applicant_name' => 'Applicant 1', 'date_submitted' => '2025-01-15', 'status' => 'Pending'],
                            ['id' => 2, 'bursary_name' => 'Bursary 2', 'applicant_name' => 'Applicant 2', 'date_submitted' => '2025-02-10', 'status' => 'Approved'],
                            ['id' => 3, 'bursary_name' => 'Bursary 3', 'applicant_name' => 'Applicant 3', 'date_submitted' => '2025-03-01', 'status' => 'Rejected'],
                        ];

                        foreach ($applications as $application): ?>
                            <tr>
                                <td><?= htmlspecialchars($application['bursary_name']); ?></td>
                                <td><?= htmlspecialchars($application['applicant_name']); ?></td>
                                <td><?= htmlspecialchars($application['date_submitted']); ?></td>
                                <td>
                                    <span class="badge <?= ($application['status'] == 'Approved') ? 'badge-success' : (($application['status'] == 'Rejected') ? 'badge-danger' : 'badge-warning'); ?>">
                                        <?= htmlspecialchars($application['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view_applications.php?id=<?= $application['id']; ?>" class="btn btn-info btn-sm">View</a>
                                    <?php if ($application['status'] == 'Pending'): ?>
                                        <a href="approve.php?id=<?= $application['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                        <a href="reject.php?id=<?= $application['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Management -->
        <div class="card">
            <div class="card-header">
                <h5>User Management</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>User 1</td>
                            <td>user1@example.com</td>
                            <td>Applicant</td>
                            <td>
                                <a href="view_users.php?id=1" class="btn btn-info btn-sm">View</a>
                                <a href="delete user.php?id=1" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>User 2</td>
                            <td>user2@example.com</td>
                            <td>Applicant</td>
                            <td>
                                <a href="view_users.php?id=2" class="btn btn-info btn-sm">View</a>
                                <a href="delete user.php?id=2" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card">
            <div class="card-header">
                <h5>Notifications</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item notification-item"><i class="fas fa-bell"></i> New application submitted for Bursary 1.</li>
                    <li class="list-group-item notification-item"><i class="fas fa-bell"></i> Bursary 2 has been approved for Applicant 2.</li>
                    <li class="list-group-item notification-item"><i class="fas fa-bell"></i> Reminder: Review pending applications by the end of the week.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
