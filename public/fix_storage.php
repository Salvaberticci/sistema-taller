<?php
// Script independiente para reparar permisos y enlace simbólico en Namecheap/cPanel
error_reporting(E_ALL);
ini_set('display_errors', 1);

$basePath = dirname(__DIR__); // Directorio raíz de Laravel (ej: /home/salvxkld/demo.salvanovasolutions.online/sistema-taller)
$publicStoragePath = $basePath . '/public/storage';
$storagePublic = $basePath . '/storage/app/public';

$messages = [];

try {
    // 1. Asegurar que la carpeta de almacenamiento de destino exista
    if (!file_exists($storagePublic)) {
        if (mkdir($storagePublic, 0755, true)) {
            $messages[] = "Creado directorio destino: $storagePublic";
        } else {
            throw new Exception("No se pudo crear el directorio destino: $storagePublic");
        }
    }

    // 2. Eliminar enlace o directorio viejo en public/storage si existe
    if (file_exists($publicStoragePath) || is_link($publicStoragePath)) {
        if (is_link($publicStoragePath)) {
            if (unlink($publicStoragePath)) {
                $messages[] = "Enlace simbólico viejo/roto eliminado de: $publicStoragePath";
            } else {
                throw new Exception("No se pudo eliminar el enlace viejo de: $publicStoragePath");
            }
        } else {
            // Es un directorio real creado por error
            $backupName = $publicStoragePath . '_backup_' . time();
            if (rename($publicStoragePath, $backupName)) {
                $messages[] = "Directorio físico public/storage renombrado a copia de seguridad en: $backupName";
            } else {
                throw new Exception("No se pudo renombrar el directorio físico de: $publicStoragePath");
            }
        }
    }

    // 3. Crear el enlace simbólico
    if (symlink($storagePublic, $publicStoragePath)) {
        $messages[] = "Enlace simbólico creado con éxito vía PHP (de $storagePublic a $publicStoragePath)";
    } else {
        $messages[] = "<span style='color:orange;'>La función symlink() falló. Intentando con comando ln -s...</span>";
        // Intentar a través de shell (si symlink() está deshabilitada en php.ini de Namecheap)
        $output = [];
        $resultCode = null;
        exec("ln -s " . escapeshellarg($storagePublic) . " " . escapeshellarg($publicStoragePath), $output, $resultCode);
        if ($resultCode === 0) {
            $messages[] = "Enlace simbólico creado con éxito usando comando del sistema (ln -s).";
        } else {
            throw new Exception("No se pudo crear el enlace simbólico usando symlink() ni ln -s.");
        }
    }

    // 4. Corregir permisos recursivos en la carpeta de almacenamiento (755 carpetas, 644 archivos)
    $dirsToFix = [
        $basePath . '/storage',
        $basePath . '/storage/app',
        $storagePublic
    ];

    foreach ($dirsToFix as $dir) {
        if (file_exists($dir)) {
            chmod($dir, 0755);
        }
    }

    if (file_exists($storagePublic)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePublic, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                chmod($item->getPathname(), 0755);
            } else {
                chmod($item->getPathname(), 0644);
            }
        }
        $messages[] = "Permisos corregidos a 755 (directorios) y 644 (archivos) dentro de storage/app/public";
    }

    echo "<html><head><title>Reparador de Almacenamiento</title></head><body style='font-family:sans-serif; background:#121824; color:#e2e8f0; padding:40px;'>";
    echo "<div style='max-width:600px; margin:auto; background:#1e293b; padding:30px; border-radius:12px; border:1px solid #334155; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);'>";
    echo "<h2 style='color:#38bdf8; margin-top:0;'>¡Reparación Completada con Éxito!</h2>";
    echo "<ul style='line-height:1.6;'><li>" . implode("</li><li>", $messages) . "</li></ul>";
    echo "<p style='color:#94a3b8; font-size:0.9em; margin-top:20px;'>Ya puedes regresar a la aplicación. Las fotos de los vehículos deberían mostrarse correctamente ahora.</p>";
    echo "</div></body></html>";

} catch (Exception $e) {
    echo "<html><head><title>Error en Reparación</title></head><body style='font-family:sans-serif; background:#121824; color:#e2e8f0; padding:40px;'>";
    echo "<div style='max-width:600px; margin:auto; background:#1e293b; padding:30px; border-radius:12px; border:1px solid #ef4444; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);'>";
    echo "<h2 style='color:#f87171; margin-top:0;'>Error durante la ejecución</h2>";
    echo "<p style='background:#7f1d1d; padding:10px; border-radius:6px; border:1px solid #b91c1c;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    if (!empty($messages)) {
        echo "<h3>Pasos logrados antes del fallo:</h3>";
        echo "<ul style='line-height:1.6;'><li>" . implode("</li><li>", $messages) . "</li></ul>";
    }
    echo "</div></body></html>";
}
