if ($http_x_forwarded_proto != "https") {
    return 301 https://$host$request_uri;
}

location / {
    try_files $uri @rewriteapp;
}

location @rewriteapp {
    rewrite ^(.*)$ /index.php$1 last;
}

# for people with app root as doc root, restrict access to a few things
location ~ ^/(composer\.|Procfile$|<?=getenv('COMPOSER_VENDOR_DIR')?>/|<?=getenv('COMPOSER_BIN_DIR')?>/) {
    deny all;
}
