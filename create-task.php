<?php

session_start();

include "includes/db.php";
$user_id = $_SESSION['user_id'];

$success = false;

if(isset($_POST['create'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO tasks(user_id, title, description, due_date)
        VALUES('$user_id', '$title', '$description', '$due_date')";

    mysqli_query($conn, $sql);

    $success = true;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - Nextask</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .task-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 550px;
            width: 100%;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .task-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .task-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .task-header p {
            font-size: 14px;
            margin: 8px 0 0 0;
            opacity: 0.9;
        }

        .task-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .priority-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .priority-option {
            position: relative;
        }

        .priority-option input {
            display: none;
        }

        .priority-label {
            display: block;
            padding: 12px;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .priority-option input:checked + .priority-label {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .priority-label:hover {
            border-color: #667eea;
        }

        .btn-create {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-create:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
        }

        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .success-content {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            max-width: 400px;
            animation: slideUp 0.3s ease-out;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: white;
            animation: scaleIn 0.3s ease-out 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-content h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .success-content p {
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        .success-buttons {
            display: flex;
            gap: 10px;
        }

        .success-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .success-btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .success-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .success-btn.secondary {
            background: #f0f3ff;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .success-btn.secondary:hover {
            background: #667eea;
            color: white;
        }

        .char-count {
            font-size: 12px;
            color: #95a5a6;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<?php if($success): ?>
    <div class="success-modal">
        <div class="success-content">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Task Created!</h2>
            <p>Your task has been created successfully and added to your task list.</p>
            <div class="success-buttons">
                <a href="dashboard.php" class="success-btn primary">
                    <i class="fas fa-arrow-right"></i> Go to Dashboard
                </a>
                <a href="create-task.php" class="success-btn secondary">
                    <i class="fas fa-plus"></i> Create Another
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="task-container">
    <div class="task-header">
        <h1>Create New Task</h1>
        <p>Add a new task to your task list</p>
    </div>

    <div class="task-body">
        <form method="POST">

            <div class="form-group">
                <label for="title">
                    <i class="fas fa-heading"></i> Task Title
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       class="form-control"
                       placeholder="e.g., Design homepage mockup"
                       maxlength="100"
                       required>
            </div>

            <div class="form-group">
                <label for="description">
                    <i class="fas fa-align-left"></i> Description
                </label>
                <textarea name="description"
                          id="description"
                          class="form-control"
                          placeholder="Provide more details about your task..."
                          maxlength="500"></textarea>
                <div class="char-count">
                    <span id="char-count">0</span>/500 characters
                </div>
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-flag"></i> Priority
                </label>
                <div class="priority-group">
                    <div class="priority-option">
                        <input type="radio" id="low" name="priority" value="low">
                        <label for="low" class="priority-label">
                            <i class="fas fa-arrow-down"></i> Low
                        </label>
                    </div>
                    <div class="priority-option">
                        <input type="radio" id="medium" name="priority" value="medium" checked>
                        <label for="medium" class="priority-label">
                            <i class="fas fa-minus"></i> Medium
                        </label>
                    </div>
                    <div class="priority-option">
                        <input type="radio" id="high" name="priority" value="high">
                        <label for="high" class="priority-label">
                            <i class="fas fa-arrow-up"></i> High
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="due_date">
                    <i class="fas fa-calendar"></i> Due Date
                </label>
                <input type="date"
                       id="due_date"
                       name="due_date"
                       class="form-control"
                       required>
            </div>

            <button type="submit" name="create" class="btn-create">
                <i class="fas fa-plus-circle"></i> Create Task
            </button>

        </form>

        <div class="back-link">
            <a href="dashboard.php">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<script>
    // Character counter for description
    document.getElementById('description').addEventListener('input', function() {
        document.getElementById('char-count').textContent = this.value.length;
    });
</script>

</body>

</html>
