<?php

include "includes/db.php";

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
    

        session_start();

	$user = mysqli_fetch_assoc($result);

	$_SESSION['user_id'] = $user['id'];
	$_SESSION['user_name'] = $user['full_name'];

	header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid email or password";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nextask</title>
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
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
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

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .login-header p {
            font-size: 14px;
            margin: 8px 0 0 0;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin: 15px 0;
            font-size: 14px;
        }

        .remember-me input {
            margin-right: 8px;
            cursor: pointer;
        }

        .remember-me label {
            margin: 0;
            cursor: pointer;
            color: #666;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #ccc;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            margin: 0 10px;
            color: #999;
            font-size: 13px;
        }

        .social-login {
            display: flex;
            gap: 10px;
        }

        .social-btn {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

        .social-btn:hover {
            border-color: #667eea;
            background: #f0f3ff;
            color: #667eea;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            animation: slideDown 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-header">
        <h1>Welcome Back</h1>
        <p>Login to your Nextask account</p>
    </div>

    <div class="login-body">
        
        <?php if(!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="your@email.com"
                       required>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
                       required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <div class="forgot-password">
                <a href="forgot-password.php">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

        </form>

        <div class="divider">
            <span>Or</span>
        </div>

        <div class="social-login">
            <a href="#" class="social-btn">
                <i class="fab fa-google"></i> Google
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-github"></i> GitHub
            </a>
        </div>

        <div class="signup-link">
            Don't have an account? <a href="register.php">Sign up here</a>
        </div>
    </div>
</div>

</body>

</html>
