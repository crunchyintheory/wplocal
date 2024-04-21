FROM php:8.3-cli
COPY sync.php sync.php
CMD [ "php", "sync.php" ]
