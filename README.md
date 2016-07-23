# Defcon's Dockerize Drupal container set for Drupal 8
This is a docker container set for Drupal 8, based on [Dockerize Drupal](https://dockerizedrupal.com/getting-started). 
It is assumed that you have gone through the [Getting Started](https://dockerizedrupal.com/getting-started/installation/linux/ubuntu/install-vhost) setup, and that your ```vhost``` is named ```dev```.

#### Current version: Drupal 8.1.7

## Directories
```
default.aliases.drushrc.php
backups/
--drupal-8.1.6.tar.gz
code/
--[apache webroot]
--sites/default/files <symlinked> to ../../../files
--sites/default/default.settings.local.php
db/
--[mysql dataroot]
--db.tar.gz
files/
--private/
tmp/
```
### Directory notes
- ```default.aliases.drushrc.php``` will need to be populated with Drush aliases you want avaialble to your container. Because they're accessed through your Docker host, you'll need to use absolute root (e.g. ```'root' => '/srv/bindings/9096c0a16f694f22a3c9c066673edfeb/code'```) and path (e.g. ```'%files' => '/srv/bindings/9096c0a16f694f22a3c9c066673edfeb/files'```) values. 
- The ```files/.htaccess``` and ```files/private/.htaccess``` files have been included. 
- The ```db/db.tar.gz``` file can be unzipped if you want to start with an empty, blank database called ```drupal```. If you don't do this, you'll need to create a database through the core install process, or through adminer/phpmyadmin (collation: ```utf8_general_ci```).
- The ```sites/default/default.settings.local.php``` file contains default overrides that are container compliant (e.g. file paths, tmp path, and db connection).


## Getting started
1. Clone this repo.
2. Rename the ```./code``` folder to the same as your new container set (i.e. ```./acme```).  _(Docker-compose assigns container names based on this folder -- e.g. acme_apache_1, acme_mysql_1, etc. -- so choose wisely)_
3. Update your ```./default.aliases.drushrc.php```
4. Update your ```./acme/host.yml``` settings:
   * Ensure port binds/forwards are correct, and use unused ports.
   * Ensure volume mount paths are correct, and that REPLACEME is replaced with your container name (e.g. acme).
5. Update your ```./acme/docker-compose.yml``` settings to replace REPLACEME with your container name (e.g. acme).
6. (Optional) For new sites, copy ```./acme/sites/default/default.services.yml``` to ```./acme/sites/default/services.yml```.
7. (Optional) Set a PHP version other than the default, 5.5 (see PHP instructions below).
8. Run ```docker-compose up -d``` from the ```./acme``` folder containing your code base.
9. (Optional) For new sites, install new site: ```crush -y site-install <installation_profile> --notify --db-url=mysqli://container:container@mysql/drupal --site-name="ACME" --account-name=admin --account-pass=admin```. Where ```<installation_profile>``` is ```standard|minimal|<custom>```.


That's it! You should be able to run ```>docker ps``` and see your new containers (i.e. ```acme_apache_1, acme_mysql_1, acme_php_1```, etc.) 

If you visit [http://dev](http://dev) (or whatever your [Dockerize Drupal vhost](https://dockerizedrupal.com/getting-started/installation/linux/ubuntu/install-vhost) is called), you should now see your new ```acme.dev``` project, and can access it, or the adminer, mailcatcher, phpmyadmin, or memcache admin pages.

## Additional Notes
### Using an alternative PHP version
1. Switch to ```./acme``` folder (i.e. the folder containing the ```host.yml``` and ```docker-compose.yml``` files).
2. Run ```drupal-compose service php set version <VERSION>``` (where <VERSION> = 5.2 5.3 5.4 5.5 5.6)
3. (Optional) If you're already created your containers, you'll need to stop and recreate them for the change to be visible 

### Data Persistence
1. Unlike the stock Dockerize Drupal container sets, this set is built with data persistence in mind. 
2. You can tear down and re-compose the entire container set, and will not lose code, databse, files, nor drush aliases. This is especially handy when switching PHP versions. 
3. The stock Dockerize Drupal container set mounts your default ~/.ssh folder. Iif your .ssh folder is elsewhere, you'll need to update the ```./code/host.yml``` file _before_ composing your container set.

### Drush/Crush
The [Dockerize Drupal instructions](https://dockerizedrupal.com/getting-started/installation/linux/ubuntu/install-crush) include the install of ```crush```, a wrapper for Drush that allows you to execute Drush commands
from your docker host, into/against containers. 

By default, those instructions will actually overwrite your host's stock Drush install (egads!). I'm not in favor of this, and instead, I installed ```crush``` along-side ```drush```. 
To do the same, when going through your original vhost setup [as described here](https://dockerizedrupal.com/getting-started/), simply follow the steps stored in 
[the script](https://raw.githubusercontent.com/dockerizedrupal/crush/master/install.sh) the 
[Dockerize Drupal instructions](https://dockerizedrupal.com/getting-started/installation/linux/ubuntu/install-crush) points you to EXCEPT for the following lines:

```php
  if [ "${?}" -ne 0 ]; then
    ln -s /usr/local/bin/crush /usr/local/bin/drush
  fi
```

If you skip the above symlink -- which hoses your default drush -- then from your docker host, you'll be able to run ```crush``` to target ```containers``` or ```drush``` as you normally would. 
Your container will see the aliases stored in your ```./default.aliases.drushrc.php``` file, which are mounted. 

