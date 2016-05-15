# flux

## Configuration Apache

```
RewriteEngine on
RewriteRule ^$  index.php?page=login  [L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?page=$1 [L,QSA]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ ?page=$1 [L,QSA]
```

## Configuration nginx

**PAS DE CACHE SUR LES RESSOURCES POUR POUVOIR MODIFIER PENDANT LE GALA**.

```
    location ~ ^/([A-z_]+)$ {
        try_files $uri /index.php?page=$1&$args;
    }

    location / {
        try_files $uri /index.php?&args;
    }

    location ~ /\.git {
        deny all;
    }
```
