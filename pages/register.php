<?php
require_once '../config/db.php';
require_once '../config/password.php';
require_once '../includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $error = 'Email already registered.';
    } else {
        $passErrors = validatePassword($pass);

        if (!empty($passErrors)) {
            $error = 'Password is not strong enough: ' . implode(' ', $passErrors);
        } else {
            $role = $_POST['role'] === 'vendor' ? 'vendor' : 'customer';
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $ins  = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $ins->execute([$name, $email, $hash, $role]);
            header('Location: login.php');
            exit;
        }
    }
}
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h4 class="mb-3">Create Account</h4>
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div> <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">I am a:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="role" id="customer"
                            value="customer" checked>
                        <label class="form-check-label" for="customer">
                            👤 Customer (buying gifts)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            name="role" id="vendor"
                            value="vendor">
                        <label class="form-check-label" for="vendor">
                            🏪 Shop Owner (selling items)
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-dark w-100">sign up</button>
            </form>
            <p class="text-center mt-3 small">Already have an account?
                <a href="login.php">Login</a>
            </p>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>