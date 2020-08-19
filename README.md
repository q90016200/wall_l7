**sudo vi /etc/hosts**
```
127.0.0.1 test.wall.com
```

**laravel .env**
```
APP_NAME=wall
APP_ENV=local
APP_KEY=base64:m2hZcCpDaR7KRsG7jdbmAfkTY7D+8qKZAmoHyPoc9Ss=
APP_DEBUG=true
APP_URL=http://test.wall.com/

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=172.28.0.5
DB_PORT=3306
DB_DATABASE=wall
DB_USERNAME=admin
DB_PASSWORD=admin

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=172.28.0.4
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_SECRET_KEY=
LINE_NOTIFY_CALLBACK_URL=http://localhost/api/lineNotify/callback

```
因使用了 (Laravel Sanctum 內的 SPA 认证)[https://learnku.com/docs/laravel/7.x/sanctum/7510#spa-authentication] `.env` 需添加 SANCTUM_STATEFUL_DOMAINS 內需添加使用的 domain
example:
```
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1,127.0.0.1:8000,::1,test.wall.com,
```

並更改 session 配置文件中用前导. 作为域的前缀：
```
'domain' => '.wall.comm',
```
**local nginx config**
```
server {
	listen 80;
	listen [::]:80;

	server_name test.wall.com;
	root /home/code/wall_l7/public;

	# index.php
	index index.php;

	# index.php fallback
	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~ \.php$ {
		fastcgi_pass   127.0.0.1:9000;
		fastcgi_index  index.php;
		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		include        fastcgi_params;
	}
}
```
line notify callback 需設定 localhost

```
server {
	listen 80;
	listen [::]:80;

	server_name localhost;
	root /home/vhost/wall_l7/public;

	# index.php
	index index.php;

	# index.php fallback
	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~ \.php$ {
		fastcgi_pass   127.0.0.1:9000;
		fastcgi_index  index.php;
		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		include        fastcgi_params;
	}
}
```

```
composer install

npm install

npm run dev
```
