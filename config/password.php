<?php function validatePassword($password)
{
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter (A-Z).';
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter (a-z).';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number (0-9).';
    }
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:",.<>?]/', $password)) {
        $errors[] = 'Password must contain at least one special character (!@#$%^&* etc).';
    }
    return $errors;
}
