<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$user = new User([
    'name' => 'Lucas',
    'email' => 'lucas@cod3r.com.br'
]);

echo User::getSelect(['name' => 'Chaves', 'email' => 'chaves@email.com']);
echo '<br>';
echo User::getSelect(['id' => 1], 'name, email');
