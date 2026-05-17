<?php

session_start();

include "includes/db.php";

$user_id = $_SESSION['user_id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM tasks
     WHERE user_id='$user_id'
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks - Nextask</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            padding: 1rem 2rem !important;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .navbar-menu {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-left: auto;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .navbar-menu a:hover {
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Main Container */
        .main-container {
            padding: 40px 20px;
        }

        .page-header {
            margin-bottom: 30px;
            animation: slideDown 0.5s ease-out;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 16px;
            margin: 5px 0 0 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            margin: 0;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .table thead th {
            color: white;
            font-weight: 600;
            border: none;
            padding: 18px 20px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            border-bottom: 1px solid #e8ecf1;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody td {
            padding: 18px 20px;
            color: #2c3e50;
            font-size: 14px;
            vertical-align: middle;
        }

        .task-id {
            font-weight: 700;
            color: #667eea;
            font-size: 13px;
        }

        .task-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .task-description {
            color: #7f8c8d;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-date {
            color: #95a5a6;
            font-weight: 500;
        }

        .task-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn.edit {
            background: #667eea;
            color: white;
        }

        .action-btn.edit:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .action-btn.delete {
            background: #f5576c;
            color: white;
        }

        .action-btn.delete:hover {
            background: #e83d54;
            transform: translateY(-2px);
        }

        .action-btn.view {
            background: #11998e;
            color: white;
        }

        .action-btn.view:hover {
            background: #0d7a72;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 80px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .add-task-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-task-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .navbar-menu {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
                margin-left: 0;
            }

            .table tbody td {
                padding: 12px 10px;
                font-size: 12px;
            }

            .task-description {
                max-width: 150px;
            }

            .action-btn {
                padding: 6px 10px;
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand" href="#">
            <i class="fas fa-tasks"></i> Nextask
        </a>
        <div class="navbar-menu">
            <a href="dashboard.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="create-task.php">
                <i class="fas fa-plus-circle"></i> New Task
            </a>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <div class="main-container">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1>All Tasks</h1>
                    <p><?php echo mysqli_num_rows($result); ?> tasks in total</p>
                </div>
                <a href="create-task.php" class="add-task-btn">
                    <i class="fas fa-plus"></i> Add New Task
                </a>
            </div>

            <!-- Tasks Table -->
            <?php if(mysqli_num_rows($result) > 0): ?>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> ID</th>
                                    <th><i class="fas fa-heading"></i> Title</th>
                                    <th><i class="fas fa-align-left"></i> Description</th>
                                    <th><i class="fas fa-calendar"></i> Due Date</th>
                                    <th style="text-align: center;"><i class="fas fa-cogs"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                                    <tr>
                                        <td class="task-id">#<?php echo $row['id']; ?></td>
                                        <td class="task-title"><?php echo $row['title']; ?></td>
                                        <td class="task-description" title="<?php echo $row['description']; ?>"><?php echo $row['description']; ?></td>
                                        <td class="task-date">
                                            <i class="fas fa-calendar-alt"></i> 
                                            <?php echo date('M d, Y', strtotime($row['due_date'])); ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="task-actions" style="justify-content: center;">
                                                <a href="#" class="action-btn view">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="#" class="action-btn edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="#" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this task?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Tasks Yet</h3>
                    <p>You haven't created any tasks yet. Start by creating your first task!</p>
                    <a href="create-task.php" class="add-task-btn">
                        <i class="fas fa-plus"></i> Create Your First Task
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>
