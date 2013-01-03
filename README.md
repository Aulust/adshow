ADShow
======

Requirements
--------------------------------------

php >= 5.3.10
node.js >= 0.6.12
mysql >= 5.5.24

Installation
--------------------------------------

Install required versions of node.js, mysql, php and nginx, npm

Install mysql driver for node.js:
```bash
npm install mysql@2.0.0-alpha3
```

Create database and tables using script from db/install.sql

Rename config.ex to config and passwd.ex to passwd in config folder. Change default settings if necessary.

Create nginx config as example:
```bash
server {
        listen   80;

        server_name  adshow.local;
        root /home/test/adshow/web;
        index index.php;

        auth_basic "Restricted";
        auth_basic_user_file  /home/test/adshow/config/passwd;

        try_files $uri $uri/ /index.php;

        location ~ \.php$ {
                fastcgi_pass   unix:/tmp/site.sock;
                fastcgi_index  index.php;
                fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include        /etc/nginx/fastcgi_params;
        }
}
```

Run node.js server with command
```bash
node main.js > log 2> err.log &
```

Usage
--------------------------------------

To insert placement in your site, use following html code as example:

```html
<iframe style="border-width: 0px; border-style: none; overflow: hidden; width: 240px; height: 200px;" src="http://adshow.local:8080/show/placement.name"></iframe>
```
Where "placement.name" is name of placement you created ‌in admin interface.

TODO
--------------------------------------

1. Load units through ajax(jsonp) as alternative to iframe.
2. Targeting system. Simple, by time and more complex, with site integration
3. Add advertising campaign interface in order to work with multiple banners
4. Refactoring code and UI

Contributors
--------------------------------------

[KingCobra](https://github.com/KingCobra90)
