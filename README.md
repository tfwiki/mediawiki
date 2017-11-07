[![Docker Automated build](https://img.shields.io/docker/automated/tfwiki/mediawiki.svg)](https://hub.docker.com/r/tfwiki/mediawiki/)
[![Docker Build Status](https://img.shields.io/docker/build/tfwiki/mediawiki.svg)](https://hub.docker.com/r/tfwiki/mediawiki/)

Team Fortress Wiki
====================

This repository is a clone from the production repository hosted on Valve's servers. It is in the process of being cleaned up and simplified into a set of Dockerfiles and supporting files, which can be used to reliably build an almost like-for-like reproduction of the Valve-hosted Team Fortress Wiki.

The key differences between the image built by these Dockerfiles and the Valve-hosted site are:
* This repository runs PHP 5.6
* ...

## Running locally

The wiki can be ran locally via `docker-compose`:

* Build a `tfwiki/mediawiki:local` image from source: `make`
* Update your hosts file to map `tfwiki.localhost` to the host IP (presumably `127.0.0.1`)
* Create `.env` file with the variables to configure your stack (`cp .env.example .env`; `.env.example` is pre-configured for running locally)
* Generate some self-signed SSL certs: `make certs`
* Bring up the stack! `docker-compose up -d`

### MediaWiki

For the first Dockerised build, we want to match (as closely as we can) to the Valve-hosted files, although with a cleaner repository.

MediaWiki do not publish a docker image for the version of MediaWiki we require (v1.26.2), so [we have a fork of their repository](https://github.com/tfwiki/mediawiki-docker) building that image, which is published to `tfwiki/mediawiki:base-1.26.2`.

Once we have the entire site running via Docker, we'll then upgrading MediaWiki.

### TF Wiki

`Dockerfile` is responsible for the actual build of the TF2 Wiki. This Dockerfile moves MediaWiki's files to match the production TF Wiki's directory structure, and then we're adding our extensions, and necessary supporting files to configure the Docker container at runtime.

We can configure this `tfwiki/mediawiki` container with the following environmental variables:

Variable              | Default              | Associated MediaWiki variable | Notes
--------------------- | -------------------- | ----------------------------- | -----
`CAPTCHA_SECRET`      | *Required*           | `$wgCaptchaSecret`            | 
`DB_DB`               | `wiki`               | `$wgDBname`                   |
`DB_HOST`             | `db`                 | `$wgDBserver`                 |
`DB_PASSWORD`         | –                    | `$wgDBpassword`               |
`DB_TYPE`             | `mysql`              | `$wgDBtype`                   |
`DB_USER`             | `wiki`               | `$wgDBuser`                   |
`GMAIL_SMTP_PASSWORD` | –                    | `$wgSMTP['password']`         |
`GMAIL_SMTP_USERNAME` | –                    | `$wgSMTP['username']`         |
`MEMCACHED_HOST`      |                     | `$wgMemCachedServers`         | If this is blank we'll use MediaWiki's default cache settings
`SECRET_KEY`          | *Required*           | `$wgSecretKey`                |
`SERVER_URL`          | *Required*           | `$wgServer`                   |
`SITENAME`            | `Team Fortress Wiki` | `$wgSitename`                 |
`STEAM_API_KEY`       |                      | N/A                           |
`VARNISH_HOST`        | `varnish`            | `$wgSquidServers`             | If this is blank and Varnish is used, MediaWiki won't be able to automatically purge items from the cache
