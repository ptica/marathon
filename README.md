Marathon app
============
Registrations + Booking

```
$ npm install
$ composer install
$ bower install
$ grunt

$ vim Config/database.php # edit db credentials
$ mysql -u user -p marathon < schema.sql
$ apache vhost is located at Config/Vhost/local.marathon.conf
$ chmod -R g+w tmp/{cache,logs} # webserver should be able to write there
```


enjoy!
