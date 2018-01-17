<?php
  $servidor = 'localhost';
  $sql_user = 'super_alpha';
  $sql_password = 'yJqfunvHFME28cEd';
  $sql_db = 'supermercat2';
  $email = 'lpierluissi@hotmail.com';
  $email_cambio_direccion = 'josep@elcomprador.cat';
  $link = mysql_connect($servidor, $sql_user, $sql_password) or die('No se pudo conectar: ' . mysql_error());
  mysql_set_charset('utf8',$link);
  mysql_select_db($sql_db) or die('No se pudo seleccionar la base de datos');
?>