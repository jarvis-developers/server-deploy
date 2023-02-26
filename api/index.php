<?php
function checkAuth(string $login, string $password): bool 
{
    $users = require __DIR__ . '/usersDB.php';

    foreach ($users as $user) {
        if ($user['login'] === $login 
            && $user['password'] === $password
        ) {
            return true;
        }
    }

    return false;
}


function getUserLogin(): ?string
{
    $loginFromCookie = $_COOKIE['login'] ?? '';
    $passwordFromCookie = $_COOKIE['password'] ?? '';

    if (checkAuth($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie;
    }

    return null;
}


if (!empty($_POST)) {
    // require __DIR__ . 'auth.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkAuth($login, $password)) {
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: admin_site.html');
    } else {
        $error = 'Ошибка авторизации';
        header('Location: index2_2.html');
    }
}
?>