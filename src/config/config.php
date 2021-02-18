<?php
// Configurações de fuso horário para data/hora e localidade para aplicação 
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

// Pastas
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));

require_once(realpath(dirname(__FILE__) . '/database.php'));