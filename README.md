# Lancer l'application #

 - A la racine du projet exécuter : `docker-compose up`
 - Aller dans le conteneur `lbctest-php-fpm` : `docker exec -it lbctest-php-fpm bash` et faire un `composer install`
 - Exécuter le script sql : `upgrade.sql`
