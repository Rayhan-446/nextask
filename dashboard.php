<?php

session_start();

include "includes/db.php";

$user_id = $_SESSION['user_id'];

$user_id = $_SESSION['user_id'];
$user_id = $_SESSION['user_id'];

// Get total tasks
$total_tasks = mysqli_query(
    $conn,
    "SELECT COUNT(*) as count
     FROM tasks
     WHERE user_id='$user_id'"
);
$total_row = mysqli_fetch_assoc($total_tasks);
$total = $total_row['count'];

// Get completed tasks (we'll use a simple approach - tasks due date has passed)
$completed_tasks = mysqli_query(
    $conn,
    "SELECT COUNT(*) as count
     FROM tasks
     WHERE due_date < CURDATE()
     AND user_id='$user_id'"
);
$completed_row = mysqli_fetch_assoc($completed_tasks);
$completed = $completed_row['count'];

// Get pending tasks (future due dates)
$pending_tasks = mysqli_query(
    $conn,
    "SELECT COUNT(*) as count
     FROM tasks
     WHERE due_date >= CURDATE()
     AND user_id='$user_id'"
);
$pending_row = mysqli_fetch_assoc($pending_tasks);
$pending = $pending_row['count'];

// Get recent tasks
$recent_tasks = mysqli_query(
    $conn,
    "SELECT * FROM tasks
     WHERE user_id='$user_id'
     ORDER BY id DESC
     LIMIT 3"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nextask</title>
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
            margin-bottom: 40px;
            animation: slideDown 0.5s ease-out;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 16px;
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

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            animation: fadeIn 0.5s ease-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
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

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.completed {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-label {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 40px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 12px;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change.up {
            color: #38ef7d;
        }

        .stat-change.down {
            color: #f5576c;
        }

        /* Tasks Section */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        .task-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-card.overdue {
            border-left-color: #f5576c;
        }

        .task-card.completed {
            border-left-color: #38ef7d;
        }

        .task-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transform: translateX(5px);
        }

        .task-info h5 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .task-info p {
            color: #95a5a6;
            font-size: 13px;
            margin: 0;
        }

        .task-status {
            font-weight: 600;
            font-size: 12px;
            margin-left: 10px;
        }

        .task-status.overdue {
            color: #f5576c;
        }

        .task-status.completed {
            color: #38ef7d;
        }

        .task-status.pending {
            color: #667eea;
        }

        .task-action {
            display: flex;
            gap: 10px;
        }

        .task-btn {
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

        .task-btn.edit {
            background: #667eea;
            color: white;
        }

        .task-btn.edit:hover {
            background: #5568d3;
        }

        .task-btn.delete {
            background: #f5576c;
            color: white;
        }

        .task-btn.delete:hover {
            background: #e83d54;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 60px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #95a5a6;
            margin-bottom: 20px;
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

        .view-all-btn {
            background: #667eea;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .view-all-btn:hover {
            background: #5568d3;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .task-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .task-action {
                width: 100%;
                margin-top: 15px;
            }

            .navbar-menu {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand" href="#">
            <i class="fas fa-tasks"></i> Nextask Dashboard
        </a>
        <div class="navbar-menu" style="margin-left: auto;">
            <a href="all-tasks.php">
                <i class="fas fa-list"></i> All Tasks
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
                <h1>
                	Welcome Back,
                	<?php echo $_SESSION['user_name']; ?>👋
                </h1>
                <p>Here's what's happening with your tasks today</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-label">Total Tasks</div>
                    <div class="stat-number"><?php echo $total; ?></div>
                    <div class="stat-change">
                        <i class="fas fa-info-circle"></i>
                        All tasks
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon completed">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Overdue</div>
                    <div class="stat-number"><?php echo $completed; ?></div>
                    <div class="stat-change down">
                        <i class="fas fa-arrow-down"></i>
                        <?php echo $total > 0 ? round(($completed/$total)*100) : 0; ?>% overdue
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-number"><?php echo $pending; ?></div>
                    <div class="stat-change up">
                        <i class="fas fa-arrow-up"></i>
                        <?php echo $total > 0 ? round(($pending/$total)*100) : 0; ?>% pending
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div style="margin-top: 40px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 class="section-title">
                        <i class="fas fa-list-check"></i> Recent Tasks
                    </h2>
                    <a href="create-task.php" class="add-task-btn">
                        <i class="fas fa-plus"></i> Add New Task
                    </a>
                </div>

                <!-- Display Recent Tasks -->
                <?php if(mysqli_num_rows($recent_tasks) > 0): ?>
                    <?php 
                    $today = new DateTime();
                    while($task = mysqli_fetch_assoc($recent_tasks)): 
                        $due_date = new DateTime($task['due_date']);
                        $is_overdue = $due_date < $today;
                        $card_class = $is_overdue ? 'overdue' : '';
                        $status_text = $is_overdue ? '⚠ Overdue' : '📅 Pending';
                        $status_class = $is_overdue ? 'overdue' : 'pending';
                    ?>
                        <div class="task-card <?php echo $card_class; ?>">
                            <div class="task-info">
                                <h5><?php echo $task['title']; ?></h5>
                                <p>
                                    Due: <?php echo date('M d, Y', strtotime($task['due_date'])); ?> 
                                    <span class="task-status <?php echo $status_class; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="task-action">
                                <a href="edit-task.php?id=<?php echo $task['id']; ?>" class="task-btn edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete-task.php?id=<?php echo $task['id']; ?>" class="task-btn delete" onclick="return confirm('Are you sure you want to delete this task?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <div style="text-align: center; margin-top: 20px;">
                        <a href="all-tasks.php" class="view-all-btn">
                            <i class="fas fa-arrow-right"></i> View All Tasks
                        </a>
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
    </div>

</body>

</html>
