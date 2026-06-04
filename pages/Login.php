

<body>
    <?php require_once '../config/db.php';
    require_once '../includes/header.php';
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $pass = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Wrong email or password.';
        }
    } ?> <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h4 class="mb-3">Login</h4> <?php if ($error): ?> <div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?> <form method="POST">
                    <div class="mb-3"> <label class="form-label">Email</label> <input type="email" name="email" class="form-control" required> </div>
                    <div class="mb-3"> <label class="form-label">Password</label> <input type="password" name="password" class="form-control" required> </div> <button class="btn btn-dark w-100">Login</button>
                </form>
                <p class="text-center mt-3 small">No account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
    <?php require_once '../includes/footer.php'; ?>
