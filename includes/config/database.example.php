<?php
// Copia este archivo como database.php y pon tus propios datos.
// database.php NO se sube a GitHub (está en .gitignore).

function conectarDB()
{
   $db = mysqli_connect('localhost', 'root', 'TU_CONTRASEÑA', 'bienesraices_crud', 3306);

   if (!$db) {
      echo 'Error: no se pudo conectar';
      exit;
   }

   return $db;
}
