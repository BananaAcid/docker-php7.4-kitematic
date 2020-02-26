# docker-php7.4-kitematic

Simple docker image optimised for easy use to run PHP 7.4-latest applications on Apache with an external path, easy to setup.

![screenshot 2020-02-26](https://user-images.githubusercontent.com/1894723/75319006-13caee00-586c-11ea-8b21-011a0f846018.png)

## Installation

Commandline

	docker run -p 8000:80 -p 8443:443 --volume ~/my-php-app:/app -d bananaacid/docker-php7.4-kitematic

To use this image with Kitematic:

- In Kitematic, press `+ New` and search for `docker-php7.4-kitematic` and press its `create` button.
- You can read up on how to do this here: https://kitematic.com/docs/
- if you have trouble finding it, to make it available in Kitematic and docker, you can use: `docker pull bananaacid/docker-php7.4-kitematic`

------------------------------------

## Intended workflow using Kitematic

1. install docker (and within its menu, Kitematic)
2. get going with this readme
3. place your PHP files in connected folder on your computer to be used by the container

...

4. start the container (e.g. in Kitematic)
5. edit your files, use git or alike
6. reload your browser

...

7. stop the container
8. turn off your computer


Using your own PHP files through Kitematic
------------------------------------

In Kitematic, 

if you pulled an image or deleted a container, you can create a new container from `+ New` -> `My Images` and click `create`.

1. click your new container in the containers area
2. in the Volumes area klick on `/app` to generate a local folder automatically or use `Settings -> Volumes -> /app -> Change` to select a specific folder where your PHP files will go
3. click on the preview picture (it might not update immediately) to open your page in the browser

Any errors will be shown in the container logs area (Apache logs and PHP error log). The used Ports will be visible and changeable in the `Settings` tab.


Manual usage
------------------------------------

To grap it from the online repository (if not yet pulled) and use it right away:

	docker run -p 8000:80 -p 8443:443 --volume ~/my-php-app:/app  bananaacid/docker-php7.4-kitematic

to control it with Kitematic, only configure basics (`-p` is optional; Kitematic would assign random ports), use:

	docker run -d -p 8000:80 -p 8443:443 bananaacid/docker-php7.4-kitematic

* `-p outside:inside` can be used to setup a port into the container - http://localhost:8000 (443 is the SSL enabled port).
* `-d` will run it in the background, other wise, all container output goes to the current console. 
* `~/my-php-app`referes to the user folder from where the PHP files should be used - can also be activated within Kitematic. 
* `--name my-php-app_container` added before the image name, will create a container with a meaningful name.
* added SSL + SSL config (v1.1)


Enable .htaccess files
------------------------------------

If you app uses .htaccess files you need to pass the ALLOW_OVERRIDE environment variable

    docker run -d -p 80:80 -e ALLOW_OVERRIDE=true bananaacid/docker-php7.4-kitematic

or set it in Kitematic `Settings -> General -> Environment Variables`.


Using SSL
------------------------------------

The volume `/ssl-crt` (with `--volume ~/my-php-app-ssl:/ssl-crt`) can be used to add your own `.crt` renamed as `server.pem` and `server.key` to be used by apache. Set a port to `443` to access it.

An example to generate those files could be with `openssl req -x509 -nodes -days 10950 -newkey rsa:2048 -out server.pem -keyout server.key`

Add the `localhost.crt` or your owhn `server.pem as .crt file` to your local certificate storage to remove SSL security errors (usually double clicking it). 

If you get an error telling you `SSLCertificateFile: file '/ssl-cert/server.pem' does not exist or is empty` you have 3 options:
1. add a `server.pem` and `server.key`
2. Kitematic: remove the volume's local folder - Settings -> Volumes -> click the remove button next to `/ssl-cert`
3. command line: remove your `--volume ???:/ssl-cert` param

----------------------------------
# Direct download links (official)

No docker registration required.

Windows
https://download.docker.com/win/stable/Docker%20for%20Windows%20Installer.exe

MAC
https://download.docker.com/mac/stable/Docker.dmg

----------------------------------
# Improvements

Based on the work of:

* Phil Plückthun, 'docker-php-kitematic'
* Fernando Mayo <fernando@tutum.co>, 'apache-php'

... over docker-php-kitematic
----------------------------------

The following things were added/changed:

* PHP 7.4 Update, with FastCGI
* all apache / php logs are visible to the console
* revamped the default webpage placeholder to be more generic
* webpage placeholder has a link to an added phpinfo file
* makefile configured to be used for building the image and testing it
* SSL added, certificates are exchangeable



... over apache-php
----------------------------------

This fork was optimised to support Kitematic.

The following things were added/changed:

* Uses a volume instead of a static directory to expose Apache's document folder
* Running Apache in the background instead of running it in the foreground
* Exposing the access.log file to STDOUT, to make it visible in Kitematic
