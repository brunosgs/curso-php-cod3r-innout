<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$user = new User([
    'name' => 'Lucas',
    'email' => 'lucas@cod3r.com.br'
]);

print_r($user);

echo '<br><br>';
$user->email = 'lucas_alterado@cod3r.com.br';

print_r($user->email);
