# Fake New Validator

Twitter Fake news validator

### Recommended software
- Ubuntu 16.04
- PHP 7.2
- MySQL
- composer
- nodejs and npm
- gulp

### First Installation
1. Clone repository
2. copy `.env.example` to `.env`
3. Create a new MySQL database and add detail to .env file
4. Run `npm run fresh`
5. Run `php artisan migrate` and `php artisan db:seed`
6. Make sure that bootstrap/cache and storage directories are writable
8. *[optional]* Create Apache virtual host based on `/server_config/apache-virtualhost.conf`

### Virtual Host
- For example domain `fakenewsvalidator.dev` follow below steps:
```
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/fakenewsvalidator.dev.conf
sudo nano /etc/apache2/sites-available/fakenewsvalidator.dev.conf
```
- Add below code in `fakenewsvalidator.dev.conf`
```
<VirtualHost *:80>
    ServerAdmin admin@fakenewsvalidator.com
    ServerName fakenewsvalidator.dev
    ServerAlias www.fakenewsvalidator.dev
    DocumentRoot /var/www/html/fakenewsvalidator/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
- Run command to enable site `sudo a2ensite fakenewsvalidator.dev.conf`
- Run command to disable default sites `sudo a2dissite 000-default.conf`

- Add host in hosts file `sudo nano /etc/hosts`

```
127.0.1.1   fakenewsvalidator.dev
127.0.1.1   www.fakenewsvalidator.dev
```

### Authors
- matrixinfologics | matrixinfologics@gmail.com | @matrix_development
- Abhinav | abhinav1.matrix@gmail.com | @abhinavmatrix

**Matrixinfologics Pvt Ltd** 2018
