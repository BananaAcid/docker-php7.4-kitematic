#!/bin/bash
chown www-data:www-data /app -R
rm -f /var/log/apache2/*


case "$ALLOW_OVERRIDE" in 
	"True"|"true"|"TRUE"|"1"|"on"|"all"|"All"|"ALL")  
		sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
		a2enmod rewrite
		export ALLOW_OVERRIDE=All
		;; 
	*) 
		unset ALLOW_OVERRIDE
		;; 
esac


source /etc/apache2/envvars

echo "APACHE_RUN_DIR ${APACHE_RUN_DIR}"
mkdir ${APACHE_RUN_DIR}

apache2
exec tail -f /var/log/apache2/* 2>/dev/null
