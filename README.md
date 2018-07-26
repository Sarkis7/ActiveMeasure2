<p align="center"><img src="http://www.activemeasure.com/images/logo.png"></p>

## Active Measure test

Test user: test@microsoft.com:billy007

Base64: dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3

###### CREATE
```bash
curl -X POST \
  http://activemeasure.local/note \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3' \
  -H 'Content-Type: application/json' \
  -d '{"title": "testTitle", "note": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'\''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."}'
```

###### READ

```bash
curl -X GET \
  http://activemeasure.local/note/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3'
```

###### UPDATE

```bash
curl -X PUT \
  http://activemeasure.local/note/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3' \
  -H 'Content-Type: application/json' \
  -d '{"id": 6, "title": "testTitle", "note": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry'\''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."}'
```

###### DELETE

```bash
curl -X DELETE \
  http://activemeasure.local/note/1 \
  -H 'Authorization: Basic dGVzdEBtaWNyb3NvZnQuY29tOmJpbGx5MDA3'
```

###### Nginx config


```bash
server {
	listen 80;
	server_name activemeasure.local;
	root /Users/brosako/Documents/ActiveMeasure/public;

	index index.php;

 	access_log /usr/local/var/log/nginx/activeMeasure.access.log;
 	error_log /usr/local/var/log/nginx/activeMeasure.error.log;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location @script{
        rewrite ^(.*)$ /index.php last;
    } 

	location ~ ^/index\.php(/|$) {
		fastcgi_pass 127.0.0.1:9000;
		fastcgi_index index.php;
		fastcgi_split_path_info ^(.+\.php)(/.*)$;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME   $document_root$fastcgi_script_name;
		fastcgi_param HTTPS             off;
		fastcgi_param ENVIRONMENT	LOCAL;
		fastcgi_param DOCUMENT_ROOT $realpath_root;
       }

	location ~ \.php$ {
        return 404;
    }
}
```
