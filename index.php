<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple insecure check for demo (use password_hash in production)
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .card-header-custom {
            background-color: #fff;
            padding-top: 2rem;
            text-align: center;
            border-bottom: none;
        }
        .brand-icon {
            font-size: 3rem;
            color: #764ba2;
            margin-bottom: 10px;
        }
        .form-control {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 12px;
            padding-left: 45px; /* Space for icon */
            border-radius: 10px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #764ba2;
            background-color: #fff;
        }
        .input-group {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            z-index: 10;
        }
        .btn-custom {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
        }
        .footer-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="card login-card p-4">
        <div class="card-header-custom">
            <div class="brand-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <h4 class="fw-bold text-dark">Welcome Back</h4>
            <p class="text-muted small">Please login to access your inventory</p>
        </div>
        
        <div class="card-body">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div><?php echo $error; ?></div>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-4 input-group">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
                </div>
                
                <div class="mb-4 input-group">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-custom text-white">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
        
        <div class="card-footer bg-white border-0 text-center pb-3">
            <p class="footer-text">Inventory Management System v1.0</p>
        </div>
    </div>

</body>
</html>