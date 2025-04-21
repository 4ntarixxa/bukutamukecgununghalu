<?php
session_start();
if (isset($_SESSION['username'])) {
    header("location:index.php");
    exit();
}

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 3rem;
            width: 350px;
            animation: fadeIn 1s ease-in-out;
        }

        .login-card h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .login-card .form-control {
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 1.1rem;
        }

        .login-card .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
        }

        .login-card .btn-primary {
            background: #6a11cb;
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 1.2rem;
        }

        .login-card .btn-primary:hover {
            background: #2575fc;
        }

        .login-card .logo {
            width: 120px;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-wrapper {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>

<body>

    <?php if (!empty($error_message)) : ?>
        <div class="alert-wrapper">
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="login-card shadow-lg">
        <div class="card-body text-center">
            <img src="img/booktamu.png" alt="Logo" class="logo" />
            <h1>Buku Tamu</h1>
            <h2>Silahkan Login</h2>
            <form method="post" action="login_proses.php">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto close alert after 5 seconds -->
    <script>
        setTimeout(function () {
            let alert = document.querySelector('.alert');
            if (alert) {
                let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
</body>

</html>
