<p align="center"><img src="http://www.activemeasure.com/images/logo.png"></p>

## Active Measure test

Test user: test@microsoft.com:billy007

Base64: dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3

###### CREATE
```bash
curl -X POST \
  http://activemeasure.local/notes \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3' \
  -H 'Content-Type: application/json' \
  -d '{"title": "testTitle", "note": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'\''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."}'
```

###### READ

```bash
curl -X GET \
  http://activemeasure.local/notes/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3'
```

###### UPDATE

```bash
curl -X PUT \
  http://activemeasure.local/notes/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3' \
  -H 'Content-Type: application/json' \
  -d '{"id": 6, "title": "testTitle", "note": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'\''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."}'
```

###### DELETE

```bash
curl -X DELETE \
  http://activemeasure.local/notes/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3'
```

###### Nginx config


```bash
server {
    server_name activemeasure.local;
    root DIR_TO_TEST_PROJECT/web;

    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app_dev.php$is_args$args;
    }

    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /usr/local/var/log/nginx/activem.error.log;
    access_log /usr/local/var/log/nginx/activem.access.log;
}
```
