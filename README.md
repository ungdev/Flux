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
location / {
  rewrite ^/$ /index.php?page=login break;
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php?page=$1 break;
  }
}
```
