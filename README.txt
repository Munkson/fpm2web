In Debian GNU/Linux environment, you need the following Debian packages:

apache2
php7.0
php-xml
php-gnupg
libapache2-mod-ruid2

After the installation of the dependent module, do not forget to run the following command:

# a2enmod userdir php7.0 ruid2



This web application is supposed to be run within the PC of the user's desktop environment.
Because the web application needs access to user's GnuPG key repository, 
the process of the web application have to be the same with that of the running desktop environment.

As a result, the web application should be deployed under the $HOME/public_html directory,
and the web server should be configured so that the PHP handler is enabled under the web application folder
with the directory owner's uid.


The author's configuration file deployed under the /etc/apache2/site-enabled/ directory:

<Directory /home/hkubo/public_html>
        AllowOverride All
        <IfModule mod_ruid2.c>
                RMode stat
        </IfModule>
</Directory>

Entry point URL: http://localhost/~(user id)/fpm2web/load.php

During the interaction with the the web application,
the desktop key agent sometimes ask you to input the pass phrase of your GnuPG secret key,
by opening a different window.
This might be peculiar behavior, but aligning to the application design.
Please enjoy!

Hiroshi Kubo
