#!/bin/bash

# No configuration is actually needed as environmental variables are
# interpreted at runtime.
# We do want to crash early if required environmental variables are missing.

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

echo "Configuring itemredirect.php"
sed -i \
    -e "s;%STEAM_API_KEY%;$STEAM_API_KEY;g" \
    -e "s;%MEMCACHED_HOST%;$MEMCACHED_HOST;g" \
    /var/www/html/scripts/itemredirect.php