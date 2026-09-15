<?php
function escape($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
