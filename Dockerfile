FROM tfwiki/mediawiki:base-1.26.2

# Luxuries
RUN apt-get update && apt-get install -y \
        vim \
        less \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

# We want Apache's rewrite module
RUN a2enmod rewrite
RUN a2enmod headers

# MediaWiki needs these extra extensions
RUN docker-php-ext-install sockets

# We want the wiki in a w/ subfolder
RUN mv /var/www/html /var/www/i-will-be-w && \
    mkdir -p /var/www/html && \
    mv /var/www/i-will-be-w /var/www/html/w
    
# Assets
COPY src/fonts /var/www/html/fonts
COPY src/favicon.ico /var/www/html/

# Shell utils
COPY src/shell /var/www/html/shell

# Valve skin
# TODO: Check how much of this is actually used, and clean up
COPY src/skins/valve /var/www/html/w/skins/valve

# MediaWiki extensions
COPY src/extensions/AbuseFilter /var/www/html/w/extensions/AbuseFilter
COPY src/extensions/CategoryTree /var/www/html/w/extensions/CategoryTree
COPY src/extensions/CodeEditor /var/www/html/w/extensions/CodeEditor
COPY src/extensions/Echo /var/www/html/w/extensions/Echo
COPY src/extensions/EmbedVideo /var/www/html/w/extensions/EmbedVideo
COPY src/extensions/GeeQuBox /var/www/html/w/extensions/GeeQuBox
COPY src/extensions/NewUserMessage /var/www/html/w/extensions/NewUserMessage
COPY src/extensions/RedditThumbnail /var/www/html/w/extensions/RedditThumbnail
COPY src/extensions/RevQuery /var/www/html/w/extensions/RevQuery
COPY src/extensions/Scribunto /var/www/html/w/extensions/Scribunto
COPY src/extensions/UserMerge /var/www/html/w/extensions/UserMerge

# Config templates
COPY configs/apache.conf /etc/apache2/sites-available/000-default.conf
COPY configs/LocalSettings.php /var/www/html/w/LocalSettings.php
COPY configs/itemredirect.php  /var/www/html/scripts/itemredirect.php

# Generate config at runtime
COPY scripts/configure-mediawiki.sh /usr/local/bin/configure-mediawiki
COPY scripts/configure-blackfire.sh /usr/local/bin/configure-blackfire
RUN chmod +x /usr/local/bin/configure-*

VOLUME /var/www/html/w/images

# Required environmental variables
ENV CAPTCHA_SECRET=
ENV DB_DATABASE='wiki'
ENV DB_HOST='db'
ENV DB_TYPE='mysql'
ENV DB_USER='root'
ENV SECRET_KEY=
ENV SERVER_URL='https://tfwiki.localhost'
ENV SITENAME='Local Team Fortress Wiki'

# Optional environmental variables
ENV DB_PASSWORD=
ENV GMAIL_SMTP_PASSWORD=
ENV GMAIL_SMTP_USERNAME=
ENV MEMCACHED_HOST=
ENV STEAM_API_KEY=
ENV VARNISH_HOST=
ENV BLACKFIRE_SOCKET=

CMD /usr/local/bin/configure-blackfire && /usr/local/bin/configure-mediawiki && apache2-foreground