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

À tester et améliorer.

**PAS DE CACHE SUR LES RESSOURCES**.

```
    location ~ ^/([A-z_]+)$ {
        try_files $uri /index.php?page=$1&$args;
    }

    location / {
        try_files $uri /index.php?&args;
    }
```
