<?php

// Setup Sentry error handling
if ($sentryUrl = getenv('SENTRY_URL')) {
    require_once "/var/www/html/w/vendor/autoload.php";
    $client = new Raven_Client($sentryUrl);
    $client->install();
}

// Core mediawiki as follows:

// Bail on old versions of PHP, or if composer has not been run yet to install
// dependencies. Using dirname( __FILE__ ) here because __DIR__ is PHP5.3+.
require_once dirname( __FILE__ ) . '/includes/PHPVersionCheck.php';
wfEntryPointCheck( 'index.php' );

require __DIR__ . '/includes/WebStart.php';

$mediaWiki = new MediaWiki();
$mediaWiki->run();