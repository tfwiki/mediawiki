#!/bin/bash

if [ ! -z "$BLACKFIRE_SOCKET" ]; then
    version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;")
    curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version
    tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp
    mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so
    printf "extension=blackfire.so\nblackfire.agent_socket=${BLACKFIRE_SOCKET}" > $PHP_INI_DIR/conf.d/blackfire.ini
fi
