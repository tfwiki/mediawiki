<?php

# This file was automatically generated by the MediaWiki installer.
# If you make manual changes, please keep track in case you need to
# recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# http://www.mediawiki.org/wiki/Manual:Configuration_settings

# If you customize your file layout, set $IP to the directory that contains
# the other MediaWiki files. It will be used as a base to locate files.
if (defined('MW_INSTALL_PATH')) {
    $IP = MW_INSTALL_PATH;
} else {
    $IP = dirname(__FILE__);
}

$path = array($IP, "$IP/includes", "$IP/languages");
set_include_path(implode(PATH_SEPARATOR, $path) . PATH_SEPARATOR . get_include_path());

require_once("$IP/includes/DefaultSettings.php");

# If PHP's memory limit is very low, some operations may fail.
ini_set('memory_limit', '1G');
# If shell memory is too low, imagemagick will fail.
$wgMaxShellMemory = 2097152;

# Max page size limit (default: 2048)
$wgMaxArticleSize = 4096;

if ($wgCommandLineMode) {
    if (isset($_SERVER) && array_key_exists('REQUEST_METHOD', $_SERVER)) {
        die("This script must be run from the command line\n");
    }
}
// TODO: Performance comparison. Sounds harmless to leave enabled.
$wgDisableOutputCompression = true;

## Disable hit counters, costs a db update per page hit, and doesn't play well with cache
$wgDisableCounters = true;
$wgHitcounterUpdateFreq = 1000;

$wgSitename         = getenv("SITENAME");
$wgServer           = getenv("SERVER_URL");
$wgEnableCanonicalServerLink = true;

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs please see:
## http://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath       = "/w";

## UPO means: this is also a user preference option

# Will be enabled later if SMTP is configured
$wgEnableEmail      = false;
$wgEnableUserEmail  = false; # UPO

$wgEmergencyContact = "webmaster@valvesoftware.com";
$wgPasswordSender = "noreply@valvesoftware.com";

$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = false;

## Database settings
$wgDBtype     = getenv("DB_TYPE");
$wgDBserver   = getenv("DB_HOST");
$wgDBname     = getenv("DB_DATABASE");
$wgDBuser     = getenv("DB_USER");
$wgDBpassword = getenv("DB_PASSWORD");

# MySQL specific settings
$wgDBprefix         = "";

# MySQL table options to use during installation or update
$wgDBTableOptions   = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Its recommended we keep this in DB on a large wiki (tens of thousands of pages; we have hundreds of thousands!)
$wgParserCacheType = CACHE_DB; # optional

# Memcache isn't reliable with multiple memcache servers
# We fixed with mcrouter in 1e861cc and tfwiki/deployment@4383723, but dont see
# a need to change session provider. DB cons don't seem expensive.
# TODO: Continually re-evaluate above claim.
$wgSessionCacheType = CACHE_DB;

# We have Varnish in front of the servers, so we don't need serverside caching.
$wgUseFileCache = false;
$wgFileCacheDirectory = "$IP/cache";
$wgShowIPinHeader = false; # Def dont want to cache this

$wgLanguageCode = "en";

$wgSecretKey = getenv("SECRET_KEY");

## Disable non-valve skins
## To remove various skins from the User Preferences choices
$wgSkipSkins = array("modern", "chick", "cologneblue", "monobook", "myskin", "nostalgia", "simple", "standard");

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'standard', 'nostalgia', 'cologneblue', 'monobook':
wfLoadSkin('Vector');
$wgDefaultSkin = 'vector';

# Disable separate Watch tab (leave in drop down menu)
$wgVectorUseIconWatch = false;

# Logo
$wgStylePath        = "$wgScriptPath/skins";
$wgStyleDirectory   = "$IP/skins";
$wgLogo             = "$wgStylePath/valve/wiki_logo.png";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
# $wgEnableCreativeCommonsRdf = true;
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";
# $wgRightsCode = ""; # Not yet used

# LOCAL ADDITIONS
# For short/pretty URLs
$wgArticlePath = "/wiki/$1";
$wgUsePathInfo = true;

# Enable subpages in all namespaces -- added JeffL 06/28/10
$wgNamespacesWithSubpages = array_fill(0, 200, true);

# The DB is read-only and the message is displayed.
$wgReadOnly = (PHP_SAPI === 'cli' || empty(trim(getenv('READ_ONLY_MESSAGE')))) ? false : trim(getenv('READ_ONLY_MESSAGE'));

# User permissions -- don't allow anons to edit
$wgGroupPermissions['*']['edit']            = false;

# Don't allow users to move user pages (thinking they can rename users)
$wgGroupPermissions['user']['move-rootuserpages'] = false; // cannot move root userpages

# Users (autoconfirmed)
$wgAutoConfirmAge = 5 * 86400; # 5 days (86,400 seconds in one day)
$wgAutoConfirmCount = 10; # 10 edits
$wgGroupPermissions['autoconfirmed']['writeapi'] = true;
$wgGroupPermissions['autoconfirmed']['autoconfirmed'] = true; # Edit semi-protected pages.

## Permissions for "moderator" group
#$wgGroupPermissions['moderator']					 = $wgGroupPermissions['user'];
$wgGroupPermissions['moderator']['autopatrol']          = true;
$wgGroupPermissions['moderator']['browsearchive']    = true;
$wgGroupPermissions['moderator']['block']            = true;
$wgGroupPermissions['moderator']['delete']           = true;
$wgGroupPermissions['moderator']['deletedhistory']   = true;
$wgGroupPermissions['moderator']['undelete']         = true;
$wgGroupPermissions['moderator']['move']             = true;
$wgGroupPermissions['moderator']['move-subpages']    = true;
$wgGroupPermissions['moderator']['move-rootuserpages'] = true;
$wgGroupPermissions['moderator']['movefile']         = true;
$wgGroupPermissions['moderator']['patrol']           = true;
$wgGroupPermissions['moderator']['protect']          = true;
$wgGroupPermissions['moderator']['editprotected']    = true;
$wgGroupPermissions['moderator']['editsemiprotected'] = true;
$wgGroupPermissions['moderator']['suppressredirect'] = true;
$wgGroupPermissions['moderator']['undelete']         = true;

## Permissions for Bot
$wgGroupPermissions['bot']['bot']               = true;
$wgGroupPermissions['bot']['autoconfirmed']     = true;
$wgGroupPermissions['bot']['noratelimit']       = true;

## Permissions for Sysops
#$wgGroupPermissions['sysop'] = $wgGroupPermissions['moderator'];
$wgGroupPermissions['sysop']['deleterevision']       = true;  // Allows sysops to delete revisions
$wgGroupPermissions['sysop']['suppressredirect'] = true;
$wgGroupPermissions['sysop']['newusers']             = true;  // Allows sysops to view new user log
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgGroupPermissions['sysop']['userrights'] = true; // Give admins full user rights editing

$wgGroupPermissions['suppress']['suppressionlog']    = false;  // "For private suppression log access"
$wgGroupPermissions['suppress']['suppressrevision']  = false;

## Temporary permissions during upgrades
#$wgGroupPermissions['user'  ]['edit']        = false;
#$wgGroupPermissions['sysop' ]['edit']        = true;
#$wgGroupPermissions['bot'   ]['edit']        = true;

# Restrict log (added for user creation)
$wgLogRestrictions = array(
    'suppress' => 'suppressionlog',
    'newusers' => 'newusers',
);

## Allow user CSS/styles
$wgAllowUserJs  = true;
$wgAllowUserCss = true;

$wgNamespaceAliases = array(
    'TF' => NS_PROJECT,
    'TFW' => NS_PROJECT,
    'Wiki' => NS_PROJECT
);

## To enable image uploads, make sure the 'images' directory
## is writable, then uncomment this:
$wgUploadPath                   = "$wgScriptPath/images";
$wgUploadDirectory              = "$IP/images";
$wgEnableUploads                = true;
$wgUseImageResize               = true;
$wgAllowExternalImages          = true;
$wgFileExtensions               = array(
    'png', 'gif', 'jpg', 'jpeg', 'webp', 'apng', 'psd', # Image files
    'wav', 'flac', 'mp3', 'ogg',                        # Sound files
    'webm',                                             # Video files
    'ttf', 'otf',                                       # Font files
    'txt', 'cfg', 'diff', 'patch',                      # Text files
    'dem'                                               # Demo files
);
$wgVerifyMimeType               = false; # Always buggy, never helpful.
$wgUseImageMagick               = true;
$wgImageMagickConvertCommand    = "/usr/bin/convert";

# Require a confirmed email address to edit
$wgEmailConfirmToEdit = false;

# Disable restriction to allow users to change the display page title with {{DISPLAYTITLE}}
# Default is to only allow a normalized version of the actual page name. -- added JeffL 7/21/09
$wgRestrictDisplayTitle = false;

# Add steam links to allowed URL protocols
array_push($wgUrlProtocols, "steam://");

# iOS bookmark logo
# TODO: replace hardcoded URL
$wgAppleTouchIcon = "http://wiki.teamfortress.com/w/images/2/21/IOS_Bookmark_Wiki_Logo.png";

# Disable spammy notifications and automatic watchlist adds by default
$wgDefaultUserOptions["enotifusertalkpages"] = false;
$wgDefaultUserOptions["enotifwatchlistpages"] = false;
$wgDefaultUserOptions["watchdefault"] = false;

# We're running dedicated job workers, no need to do this in any HTTP requests
$wgJobRunRate = 0;

// Disable database-intensive features (certain special pages); we'll render those via cronjobbed maintenance scripts
$wgMiserMode = true;
$wgQueryCacheLimit = 10000;


#
## Third Party Extensions
#

// Setup Sentry error handling
if ($sentryUrl = getenv('SENTRY_DSN')) {
    wfLoadExtension('Sentry');
    $wgSentryDsn = $sentryUrl;

    // wfLoadExtension('Buggy');
}

# Wikipedia parser extended functions
#  upgraded to 1.5.1, RJackson 05/15/13
require_once("$IP/extensions/ParserFunctions/ParserFunctions.php");

# Hopefully NoCaptcha will squash dem bots
wfLoadExtensions(['ConfirmEdit', 'ConfirmEdit/ReCaptchaNoCaptcha']);
$wgCaptchaClass = 'ReCaptchaNoCaptcha';
$wgReCaptchaSiteKey = getenv('RECAPTCHA_KEY');
$wgReCaptchaSecretKey = getenv('RECAPTCHA_SECRET');

$wgGroupPermissions['*']['skipcaptcha'] = false;
$wgGroupPermissions['user']['skipcaptcha'] = false;
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = false;
$wgGroupPermissions['bot']['skipcaptcha'] = true; // registered bots
$wgGroupPermissions['sysop']['skipcaptcha'] = true;
$wgGroupPermissions['moderator']['skipcaptcha'] = true;

wfLoadExtension('UserMerge');
$wgGroupPermissions['bureaucrat']['usermerge'] = true;

require_once("$IP/extensions/Cite/Cite.php");
wfLoadExtension('CiteThisPage');

wfLoadExtension('EmbedVideo');

wfLoadExtension('ImageMap');

wfLoadExtension('CategoryTree');

wfLoadExtension('Interwiki');
$wgGroupPermissions['*']['interwiki'] = false;
$wgGroupPermissions['sysop']['interwiki'] = true;

wfLoadExtension('TitleBlacklist');
$wgTitleBlacklistSources = array(
    array(
        'type' => 'localpage',
        'src'  => 'MediaWiki:Titleblacklist'
    )
);

wfLoadExtension('SpamBlacklist');

wfLoadExtension('Nuke');

wfLoadExtension('WikiEditor');

wfLoadExtension('Renameuser');
$wgGroupPermissions['sysop']['renameuser'] = true;

wfLoadExtension('MultimediaViewer');

require_once("$IP/extensions/RedditThumbnail/RedditThumbnail.php");
$wgRedditThumbnailImage = 'http://wiki.teamfortress.com/w/images/3/3f/Reddit_thumbnail.png';

wfLoadExtension('Scribunto');
$wgScribuntoDefaultEngine = 'luasandbox';

wfLoadExtension('CodeEditor');
$wgScribuntoUseCodeEditor = true;

wfLoadExtension('Echo');

wfLoadExtension('NewUserMessage');
$wgNewUserSuppressRC = true;

wfLoadExtension('AbuseFilter');
$wgGroupPermissions['*']['abusefilter-view'] = false;
$wgGroupPermissions['*']['abusefilter-log'] = false;
$wgGroupPermissions['sysop']['abusefilter-modify'] = true;
$wgGroupPermissions['sysop']['abusefilter-log-detail'] = true;
$wgGroupPermissions['sysop']['abusefilter-view'] = true;
$wgGroupPermissions['sysop']['abusefilter-log'] = true;
$wgGroupPermissions['sysop']['abusefilter-private'] = true;
$wgGroupPermissions['sysop']['abusefilter-modify-restricted'] = true;
$wgGroupPermissions['sysop']['abusefilter-revert'] = true;


wfLoadExtension('CheckUser');
$wgGroupPermissions['sysop']['checkuser'] = true;
$wgGroupPermissions['sysop']['checkuser-log'] = true;

wfLoadExtension('Flow');

wfLoadExtension('Thanks');


// VARNISH_HOST can be a CSV of hostnames
if (array_key_exists('VARNISH_HOST', $_ENV)) {
    $wgUseSquid = true;
    $wgUsePrivateIPs = true;

    // Resolve to IPs, in case some/all of these hosts are round-robin DNS:
    // We must be able to PURGE all varnish hosts
    $varnishHosts = explode(',', $_ENV['VARNISH_HOST']);
    $varnishIps = array_filter(array_map(function ($host) {
        if (strpos($host, ':') === false) {
            return gethostbynamel($host);
        }

        // Preserve given port
        list($host, $port) = explode(':', $host);
        $ips = gethostbynamel($host) ?: [];

        return array_map(function ($ip) use ($port) {
            return sprintf("%s:%s", $ip, $port);
        }, $ips);
    }, $varnishHosts));

    // Flatten 2d array
    if (!empty($varnishIps)) {
        $wgSquidServers = call_user_func_array('array_merge', $varnishIps);
    }
}

// TRUSTED_PROXIES can be a CSV of hostnames
if (array_key_exists('TRUSTED_PROXIES', $_ENV)) {

    // Resolve to IPs, in case some/all of these hosts are round-robin DNS:
    $trustedProxiesHosts = explode(',', $_ENV['TRUSTED_PROXIES']);
    $trustedProxiesIps = array_filter(array_map(function ($host) {
        if (strpos($host, '/') !== false) {
            // CIDR notation, keep as is
            return [$host];
        }

        if (strpos($host, ':') === false) {
            return gethostbynamel($host);
        }

        // Preserve given port
        list($host, $port) = explode(':', $host);
        $ips = gethostbynamel($host) ?: [];

        return array_map(function ($ip) use ($port) {
            return sprintf("%s:%s", $ip, $port);
        }, $ips);
    }, $trustedProxiesHosts));

    // Flatten 2d array
    if (!empty($trustedProxiesIps)) {
        $wgSquidServersNoPurge = call_user_func_array('array_merge', $trustedProxiesIps);
    }
}

if ($memcachedHost = getenv('MEMCACHED_HOST')) {
    $wgMemCachedServers = [
        $memcachedHost
    ];
    $wgMainCacheType = CACHE_MEMCACHED;
}

// Configure SMTP if any SMTP env variables are set
$smtpEnvVarMap = array(
    'SMTP_HOST' => 'host',
    'SMTP_IDHOST' => 'IDHost',
    'SMTP_PORT' => 'port',
    'SMTP_AUTH' => 'auth',
    'SMTP_USERNAME' => 'username',
    'SMTP_PASSWORD' => 'password',
);
$smtpEnvVars = array_filter(array_intersect_key($_ENV, $smtpEnvVarMap));
if (!empty($smtpEnvVars)) {
    $wgSMTP = array();
    foreach ($smtpEnvVars as $key => $val) {
        $properKey = $smtpEnvVarMap[$key];

        // Cast certain values to expected types
        switch ($properKey) {
            case 'port':
                $val = (int) $val;
                break;

            case 'auth':
                $val = (bool) $val;
                break;
        }

        $wgSMTP[$properKey] = $val;
    }

    $wgEnableEmail = true;
    $wgEnableUserEmail = true;
    $wgUserEmailUseReplyTo = true; // Always send "from" wiki
    $wgEmailAuthentication = true;
}

if (array_key_exists('EMAIL_EMERGENCY_CONTACT', $_ENV)) {
    $wgEmergencyContact = $_ENV['EMAIL_EMERGENCY_CONTACT'];
}

if (array_key_exists('EMAIL_PASSWORD_SENDER', $_ENV)) {
    $wgPasswordSender = $_ENV['EMAIL_PASSWORD_SENDER'];
}
