<?php
require_once "./wplocal/wp-config.php";
ob_start();
?>
WORDPRESS_DB_NAME=<?php echo DB_NAME; ?>

WORDPRESS_DB_USER=<?php echo DB_USER; ?>

WORDPRESS_DB_PASSWORD=<?php echo DB_PASSWORD; ?>

WORDPRESS_TABLE_PREFIX=<?php echo $table_prefix; ?>

MYSQL_DATABASE=<?php echo DB_NAME; ?>

MYSQL_USER=<?php echo DB_USER; ?>

MYSQL_PASSWORD=<?php echo DB_PASSWORD; ?>
<?php
file_put_contents("./wplocal/wplocal.env", ob_get_clean());

exec("chgrp -R 33 /wplocal/wp-content");
exec("chmod -R 775 /wplocal/wp-content");
?>
