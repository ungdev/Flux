# flux

Flux nécessite PHP7 et mysql pour fonctionner. Vous devez créer le fichier `config/config.php` (avec l'exemple `config/config.php.example`) pour configurer les différentes variables du projet.

Un exemplaire de la base de données d'avant le gala de 2016 a été mis dans `db.sql`. Le gala dispose normalement dans ses archives de la db en fin de soirée.

## Configuration nginx

```
server {
    listen 80;
    server_name flux.uttnetgroup.fr;
    server_name bar.utt.fr;

    root /var/www/flux/web/;

    location ~ /\.git {
        deny all;
    }

    location / {
	try_files $uri /app.php$is_args$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_index /app.php;
        fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
        include fastcgi_params;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}


```
