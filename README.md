# Team Fortress Wiki

Here lies the lil sprinklin' of config and extensions that turns MediaWiki into the Team Fortress Wiki.

The [Dockerfile](./Dockerfile) is our golden source of truth. It builds atop MediaWiki's own docker images, drops in our config and extensions, and exposes a few environmental variables to configure the site.

## Running locally

The wiki can be ran locally via `docker-compose`:

- Build a `tfwiki/mediawiki:local` image from source: `make`
- Update your hosts file to map `tfwiki.localhost` to the host IP (presumably `127.0.0.1`)
- Create `.env` file with the variables to configure your stack (`cp .env.example .env`; `.env.example` is pre-configured for running locally)
- Generate some self-signed SSL certs: `make certs`
- Bring up the stack! `docker-compose up -d`

## Configuration

| Variable                  | Default                               | Associated MediaWiki variable | Notes                                                                                                  |
| ------------------------- | ------------------------------------- | ----------------------------- | ------------------------------------------------------------------------------------------------------ |
| `DB_DB`                   | `wiki`                                | `$wgDBname`                   |
| `DB_HOST`                 | `db`                                  | `$wgDBserver`                 |
| `DB_PASSWORD`             | –                                     | `$wgDBpassword`               |
| `DB_TYPE`                 | `mysql`                               | `$wgDBtype`                   |
| `DB_USER`                 | `wiki`                                | `$wgDBuser`                   |
| `EMAIL_EMERGENCY_CONTACT` | \*Required with SMTP\_\*\*            | `$wgEmergencyContact`         |
| `EMAIL_PASSWORD_SENDER`   | \*Required with SMTP\_\*\*            | `$wgPasswordSender`           |
| `MEMCACHED_HOST`          |                                       | `$wgMemCachedServers`         | Can declare CSV. If this is blank we'll use MediaWiki's default cache settings                         |
| `READ_ONLY_MESSAGE`               | -                                     | `$wgReadOnly`                 | If set, puts the Wiki into read-only mode with the given message.                                      |
| `RECAPTCHA_KEY`           | _Required_                            | `$wgReCaptchaSiteKey`         | Credentials for a ReCaptcha v2 Tickbox                                                                 |
| `RECAPTCHA_SECRET`        | _Required_                            | `$wgReCaptchaSecretKey`       | Credentials for a ReCaptcha v2 Tickbox                                                                 |
| `SECRET_KEY`              | _Required_                            | `$wgSecretKey`                |
| `SENTRY_DSN`              | -                                     |                               | Used to report errors to [Sentry](https://sentry.io)                                                   |
| `SERVER_URL`              | _Required_                            | `$wgServer`                   |
| `SITENAME`                | `Team Fortress Wiki`                  | `$wgSitename`                 |
| `SMTP_AUTH`               | -                                     | `$wgSMTP['auth']`             |
| `SMTP_HOST`               | -                                     | `$wgSMTP['Host']`             |
| `SMTP_IDHOST`             | -                                     | `$wgSMTP['IDHost']`           |
| `SMTP_PASSWORD`           | -                                     | `$wgSMTP['password']`         |
| `SMTP_PORT`               | -                                     | `$wgSMTP['port']`             |
| `SMTP_USERNAME`           | -                                     | `$wgSMTP['username']`         |
| `STEAM_API_KEY`           |                                       | N/A                           |
| `TRUSTED_PROXIES`         | `wiki.teamfortress.com,10.138.0.0/24` | `\$wgSquidServersNoPurge`     | Can declare CSV. Make sure MediaWiki can properly resolve IP addresses through external load balancers |
| `VARNISH_HOST`            | `varnish`                             | `$wgSquidServers`             | Can declare CSV. If this is blank and Varnish is used, MediaWiki won't purge items from the cache      |

## Versioning

`tfwiki/mediawiki:[medawiki maj.min]-tfwiki[n]`

We're not following semantic versioning or anything like that, because this is not a published package or product. It's being maintained in the open, but there's only one Team Fortress wiki y'know.

Anywho, before October 2020 we were being lazy with our releases. Soon as we were ready to migrate to the Cloud we tagged 1.0.0 and have just incremented the patch number ever since.

To introduce a bit more structure and clarity, from October 2020 onwards we'll follow MediaWiki's major.minor version, and then stick our own suffix on that to continue with our lazy incrementing strategy.
