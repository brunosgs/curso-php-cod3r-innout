<?php
function requireValidSession($requiresAdmin = false)
{
    $user = $_SESSION['user'];

    if (!isset($user)) {
        header("Location: LoginController.php");
        exit();
    } elseif ($requiresAdmin && !$user->is_admin) {
        addErrorMessage('Acesso negado!');
        header("Location: DayRecordsController.php");
        exit();
    }
}