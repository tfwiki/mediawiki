#!/bin/bash

required_vars=( CAPTCHA_SECRET DB_DATABASE DB_HOST DB_TYPE DB_USER SECRET_KEY SERVER_URL SITENAME )
missing_vars=
current_var=
for required_var in "${required_vars[@]}"
do
    eval current_var=\$$required_var
    if [ -z "$current_var" ] ; then
        echo "Required variable $required_var not set"
        missing_vars=true
    fi
done

if [ "$missing_vars" = true ] ; then
    echo "Required variables are not set. See above for details."
    exit 1
fi

echo "Configuring LocalSettings.php"
if [ ! -z "$VARNISH_HOST" ]; then
    cat <<EOM >> /var/www/html/w/LocalSettings.php
\$wgUseSquid = true;
\$wgUsePrivateIPs = true;
\$wgSquidServers = array('$VARNISH_HOST');
EOM
fi

if [ ! -z "$MEMCACHED_HOST" ]; then
    cat <<EOM >> /var/www/html/w/LocalSettings.php
## Shared memory settings
\$wgMainCacheType = CACHE_MEMCACHED;
\$wgMemCachedServers = array (
  0 => '$MEMCACHED_HOST:11211'
);
EOM
fi

sed -i \
    -e "s;%SITENAME%;$SITENAME;g" \
    -e "s;%SERVER_URL%;$SERVER_URL;g" \
    -e "s;%DB_TYPE%;$DB_TYPE;g" \
    -e "s;%DB_HOST%;$DB_HOST;g" \
    -e "s;%DB_DATABASE%;$DB_DATABASE;g" \
    -e "s;%DB_USER%;$DB_USER;g" \
    -e "s;%DB_PASSWORD%;$DB_PASSWORD;g" \
    -e "s;%SECRET_KEY%;$SECRET_KEY;g" \
    -e "s;%GMAIL_SMTP_USERNAME%;$GMAIL_SMTP_USERNAME;g" \
    -e "s;%GMAIL_SMTP_PASSWORD%;$GMAIL_SMTP_PASSWORD;g" \
    -e "s;%CAPTCHA_SECRET%;$CAPTCHA_SECRET;g" \
    /var/www/html/w/LocalSettings.php

echo "Configuring itemredirect.php"
sed -i \
    -e "s;%STEAM_API_KEY%;$STEAM_API_KEY;g" \
    -e "s;%MEMCACHED_HOST%;$MEMCACHED_HOST;g" \
    /var/www/html/scripts/itemredirect.php