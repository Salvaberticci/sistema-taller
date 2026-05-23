<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "¡OPcache de PHP limpiado con éxito en el servidor!";
} else {
    echo "OPcache no está habilitado o la función opcache_reset está desactivada.";
}
