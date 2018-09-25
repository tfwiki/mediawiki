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
if( defined( 'MW_INSTALL_PATH' ) ) {
	$IP = MW_INSTALL_PATH;
} else {
	$IP = dirname( __FILE__ );
}

// Setup Sentry error handling
require_once $IP . "/vendor/autoload.php";
if ($sentryUrl = getenv('SENTRY_DSN')) {
    $client = new Raven_Client($sentryUrl, [
        'name' => getenv('sitename')
    ]);
    $client->install();
}

$path = array( $IP, "$IP/includes", "$IP/languages" );
set_include_path( implode( PATH_SEPARATOR, $path ) . PATH_SEPARATOR . get_include_path() );

require_once( "$IP/includes/DefaultSettings.php" );

# If PHP's memory limit is very low, some operations may fail.
ini_set( 'memory_limit', '1G' );
# If shell memory is too low, imagemagick will fail.
$wgMaxShellMemory = 2097152;

# Max page size limit (default: 2048)
$wgMaxArticleSize = 4096;

if ( $wgCommandLineMode ) {
	if ( isset( $_SERVER ) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
		die( "This script must be run from the command line\n" );
	}
}
## Uncomment this to disable output compression
$wgDisableOutputCompression = true;

## Disable hit counters, costs a db update per page hit, and doesn't play well with cache
$wgDisableCounters = true;
$wgHitcounterUpdateFreq = 1000;

$wgSitename         = getenv("SITENAME");
$wgServer           = getenv("SERVER_URL");

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs please see:
## http://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath       = "/w";

## UPO means: this is also a user preference option

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

# Experimental charset support for MySQL 4.1/5.0.
$wgDBmysql5 = true;

# Profiling
#$wgDebugLogFile = "$IP/cache/log.txt";
#$wgProfileLimit = 1.0;
#$wgProfiling = true;

# Recommended at http://www.mediawiki.org/wiki/Memcached
# Hoping this fixes session hijack false warning. - Bryn
# Don't need to explicitly set these, they'll be inherited from $wgMainCacheType - rjackson 2017-09-28
#$wgMessageCacheType = CACHE_MEMCACHED; # optional

# Its recommended we keep this in DB on a large wiki (tens of thousands of pages; we have hundreds of thousands!)
$wgParserCacheType = CACHE_DB; # optional

# Memcache isn't reliable with multiple memcache servers
$wgSessionCacheType = CACHE_DB;

# Use local file cache of page output, this may not be 100% correct for some pages with variables
# See: http://www.mediawiki.org/wiki/Manual:File_cache, this is a stop gap to stop it kiling the forums
# during the holiday sale until we can implement a good reverse proxy setup.
$wgUseFileCache = false; /* default: false */
$wgFileCacheDirectory = "$IP/cache";
$wgShowIPinHeader = false;

#Flags to decrease database locking
$wgAntiLockFlags = ALF_NO_LINK_LOCK | ALF_NO_BLOCK_LOCK;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
# $wgHashedUploadDirectory = false;

## If you have the appropriate support software installed
## you can enable inline LaTeX equations:
$wgUseTeX           = false;

$wgLocalInterwiki   = strtolower( $wgSitename );

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

$wgDiff3 = "/usr/bin/diff3";

# When you make changes to this configuration file, this will make
# sure that cached pages are cleared.
#$wgCacheEpoch = max( $wgCacheEpoch, gmdate( 'YmdHis', @filemtime( __FILE__ ) ) );

# LOCAL ADDITIONS
# For short/pretty URLs
$wgArticlePath = "/wiki/$1";
$wgUsePathInfo = true;

# Enable subpages in all namespaces -- added JeffL 06/28/10
$wgNamespacesWithSubpages = array_fill(0, 200, true);

# The DB is read-only and the message is displayed.
#$wgReadOnly = "<b style=\"color:red;\">Attention!</b> The site is currently undergoing system maintenance and is locked from editing.";

# User permissions -- don't allow anons to edit
$wgGroupPermissions['*']['edit']            = false;

# Don't allow users to move user pages (thinking they can rename users)
$wgGroupPermissions['user']['move-rootuserpages'] = false; // cannot move root userpages

# Users (autoconfirmed)
$wgAutoConfirmAge = 5*86400; # 5 days (86,400 seconds in one day)
$wgAutoConfirmCount = 10; # 10 edits
$wgGroupPermissions['autoconfirmed']['writeapi'] = true;
$wgGroupPermissions['autoconfirmed']['autoconfirmed'] = true; # Edit semi-protected pages.

## Permissions for "moderator" group
#$wgGroupPermissions['moderator']					 = $wgGroupPermissions['user'];
$wgGroupPermissions['moderator']['autopatrol'] 		 = true;
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
$wgGroupPermissions['moderator']['editsemiprotected']= true;
$wgGroupPermissions['moderator']['suppressredirect'] = true;
$wgGroupPermissions['moderator']['undelete']         = true;

## Permissions for Bot
$wgGroupPermissions['bot']['bot']               = true;
$wgGroupPermissions['bot']['autoconfirmed']     = true;
$wgGroupPermissions['bot']['noratelimits']      = true;

## Permissions for Sysops
#$wgGroupPermissions['sysop'] = $wgGroupPermissions['moderator'];
$wgGroupPermissions['sysop']['deleterevision']       = false;  // Allows sysops to delete revisions
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

# Inline Diff
$wgEnableHtmlDiff = true;

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
# Allow direct http uploads
$wgAllowCopyUploads = false;

# Require a confirmed email address to edit
$wgEmailConfirmToEdit = false;

# Hide IP for anons
$wgShowIPinHeader = false;

# Disable restriction to allow users to change the display page title with {{DISPLAYTITLE}}
# Default is to only allow a normalized version of the actual page name. -- added JeffL 7/21/09
$wgRestrictDisplayTitle = false;

# Add steam links to allowed URL protocols
array_push( $wgUrlProtocols, "steam://" );

# iOS bookmark logo
# TODO: replace hardcoded URL
$wgAppleTouchIcon = "http://wiki.teamfortress.com/w/images/2/21/IOS_Bookmark_Wiki_Logo.png";

# Disable spammy notifications and automatic watchlist adds by default
$wgDefaultUserOptions["enotifusertalkpages"] = false;
$wgDefaultUserOptions["enotifwatchlistpages"] = false;
$wgDefaultUserOptions["watchdefault"] = false;

#
## Third Party Extensions
#

# Wikipedia parser extended functions
#  upgraded to 1.5.1, RJackson 05/15/13
require_once("$IP/extensions/ParserFunctions/ParserFunctions.php");

## ConfirmEdit and FancyCaptcha
require_once( "$IP/extensions/ConfirmEdit/ConfirmEdit.php" );
require_once( "$IP/extensions/ConfirmEdit/QuestyCaptcha.php" );

## ConfirmEdit settings
# $ceAllowConfirmedEmail = true;
$wgCaptchaClass = 'QuestyCaptcha';

## QuestyCaptcha settings, pwiki method
#$randomHash = substr(sha1(strval(rand())), rand(1, 4), rand(12, 16));
#$randomHashSplitIndex = rand(2, strlen($randomHash) - 2);
#$randomHashPart1 = substr($randomHash, 0, $randomHashSplitIndex);
#$randomJunk = substr(sha1(strval(rand())), rand(1, 4), rand(12, 16));
#$randomHashPart2 = substr($randomHash, $randomHashSplitIndex);
#$wgCaptchaQuestions[] = array( 'question' => '(Anti-spam) Please enter the following characters into the textfield (do not copy/paste, it will not paste the right thing): <code>'.$randomHashPart1.'<span style="display: inline-block; width: 0px; opacity: 0; overflow: hidden">'.$randomJunk.'</span>'.$randomHashPart2.'</code>', 'answer' =>
#    $randomHash
#);

$wgCaptchaQuestions[] = array(
    'question' => 'Which company developed <a href="/wiki/Team_Fortress_2">Team Fortress 2</a>?',
    'answer' => array('valve', 'valvesoftware', 'valve software', 'valve corporation')
);
$wgCaptchaQuestions[] = array(
    'question' => 'From which city does the <a href="/wiki/Scout#Bio">Scout</a> come from?',
    'answer' => array('boston', 'boston massachusetts', 'boston, massachusetts')
);
$wgCaptchaQuestions[] = array(
    'question' => 'Which was the <a href="/wiki/Soldier#Bio">Soldier</a>\s favourite World War?',
    'answer' => array('2', 'two')
);
$wgCaptchaQuestions[] = array(
    'question' => 'What is the <a href="/wiki/Demoman#Bio">Demoman</a>\'s name?',
    'answer' => array('tavish', 'tavish degroot', 'tavish finnegan degroot')
);
$wgCaptchaQuestions[] = array(
    'question' => 'What is the <a href="/wiki/Heavy#Bio">Heavy</a>\'s motto?',
    'answer' => array('shooting good', 'shooting good.', '"shooting good."')
);
$wgCaptchaQuestions[] = array(
    'question' => 'What is the <a href="/wiki/Engineer#Bio">Engineer</a>\'s job?',
    'answer' => 'area denial'
);
#$wgCaptchaQuestions[] = array(
#    'question' => '',
#    'answer' => ''
#);

$wgCaptchaTriggers['addurl']                        = true;  // Force Captcha when adding urls to pages
$wgGroupPermissions['moderator']['skipcaptcha']     = true;  // Disable Captcha for moderators
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = true;  // Disable Captcha for autoconfirmed users

## FancyCaptcha settings
$wgCaptchaDirectory = "$wgUploadDirectory/alpha";  // directory to store captcha images
$wgCaptchaSecret = getenv("CAPTCHA_SECRET");

# Javascript error tracking
wfLoadExtension( 'Sentry' );
$wgSentryDsn = getenv('SENTRY_DSN');


# Uploading local data
#require_once 'extensions/SpecialUploadLocal/SpecialUploadLocal.php';
#$wgUploadLocalDirectory = $IP . '/images/import/';
### Causing errors with 1.20.5 upgrade; removing for now. - RJ

# UserMerge extension
wfLoadExtension( 'UserMerge' );
$wgGroupPermissions['bureaucrat']['usermerge'] = true;

# Cite extension
#  upgraded to aa635f0, RJackson 05/15/13
require_once("$IP/extensions/Cite/Cite.php");
wfLoadExtension( 'CiteThisPage' );

# EmbedVideoPlus extension (YouTube videos)
#  upgraded to 1.0, RJackson 05/14/13
require_once("$IP/extensions/EmbedVideo/EmbedVideo.php");

# ImageMap extension
#  upgraded to 50d05ff, RJackson 05/15/13
require_once("$IP/extensions/ImageMap/ImageMap.php");

# CategoryTree extension -- JeffLane 6/14/11
#  upgraded to f5d36el, RJackson 05/15/13
$wgUseAjax = true;
require_once("{$IP}/extensions/CategoryTree/CategoryTree.php");

# Special:Interwiki extension -- JeffLane 6/20/11
#  upgraded to 2.2 20120425, RJackson 05/15/13
require_once("$IP/extensions/Interwiki/Interwiki.php");
$wgGroupPermissions['*']['interwiki'] = false;
$wgGroupPermissions['sysop']['interwiki'] = true;

# Extension:TitleBlacklist extension -- Gvegnel 3/26/12
require_once("{$IP}/extensions/TitleBlacklist/TitleBlacklist.php");
$wgTitleBlacklistSources = array(
  array(
    'type' => TBLSRC_LOCALPAGE,
    'src'  => 'MediaWiki:Titleblacklist'
  )
);

# Set to 0 and use cron job instead if performance issues arise
$wgJobRunRate = 0.01;

# SpamBlacklist	d6fae90 -- RJackson 05/18/13
require_once( "$IP/extensions/SpamBlacklist/SpamBlacklist.php" );

# Nuke ge01d28 -- RJackson 05/21/13
require_once( "$IP/extensions/Nuke/Nuke.php" );

# WikiEditor 8383c9c -- RJackson 05/21/13
require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );
    # Enables use of WikiEditor by default but still allow users to disable it in preferences
        $wgDefaultUserOptions['usebetatoolbar'] = 1;
        $wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
    # Displays the Preview and Changes tabs
        $wgDefaultUserOptions['wikieditor-preview'] = 1;

# RenameUser 5faeac9 -- RJackson 05/21/13
require_once("$IP/extensions/Renameuser/Renameuser.php");
$wgGroupPermissions['sysop']['renameuser'] = true;

require_once "$IP/extensions/MultimediaViewer/MultimediaViewer.php";

# Moussekateer's RedditThumbnail extension for setting thumbnail images for links on reddit
require_once("$IP/extensions/RedditThumbnail/RedditThumbnail.php");
$wgRedditThumbnailImage = 'http://wiki.teamfortress.com/w/images/3/3f/Reddit_thumbnail.png';

# Scribunto extension for running lua code on wiki -- Moussekateer 16/11/13
require_once "$IP/extensions/Scribunto/Scribunto.php";
$wgScribuntoDefaultEngine = 'luastandalone';

# CodeEditor extension for more featured editor for code pages -- Moussekateer 16/11/13
require_once( "$IP/extensions/CodeEditor/CodeEditor.php" );
$wgScribuntoUseCodeEditor = true;

# New MediaWiki notification system
require_once "$IP/extensions/Echo/Echo.php";

# NewUserMessage extension
wfLoadExtension( 'NewUserMessage' );
$wgNewUserSuppressRC = true;

# DISABLE REGISTRATION -- RJackson 14/Dec/2015
# Intended to be temporary, beacuse there are a billion spambots signing up and spamming.
#$wgGroupPermissions['*']['createaccount'] = false;

# AbuseFilters extension
wfLoadExtension( 'AbuseFilter' );
$wgGroupPermissions['sysop']['abusefilter-modify'] = true;
$wgGroupPermissions['sysop']['abusefilter-log-detail'] = true;
$wgGroupPermissions['sysop']['abusefilter-view'] = true;
$wgGroupPermissions['sysop']['abusefilter-log'] = true;
$wgGroupPermissions['sysop']['abusefilter-private'] = true;
$wgGroupPermissions['sysop']['abusefilter-modify-restricted'] = true;
$wgGroupPermissions['sysop']['abusefilter-revert'] = true;


wfLoadExtension( 'CheckUser' );
$wgGroupPermissions['sysop']['checkuser'] = true;
$wgGroupPermissions['sysop']['checkuser-log'] = true;

// VARNISH_HOST can be a CSV of hostnames
if (array_key_exists('VARNISH_HOST', $_ENV)) {
    $wgUseSquid = true;
    $wgUsePrivateIPs = true;
    
    // Resolve to IPs, in case some/all of these hosts are round-robin DNS:
    // We must be able to PURGE all varnish hosts
    $varnishHosts = explode(',', $_ENV['VARNISH_HOST']);
    $varnishIps = array_filter(array_map(function($host) {
        if (strpos($host, ':') === false) {
            return gethostbynamel($host);
        }

        // Preserve given port
        list($host, $port) = explode(':', $host);
        $ips = gethostbynamel($host) ?: [];

        return array_map(function($ip) use ($port) {
            return sprintf("%s:%s", $ip, $port);
        }, $ips);
    }, $varnishHosts));

    // Flatten 2d array
    if (!empty($varnishIps)) {
        $wgSquidServers = call_user_func_array(array_merge, $varnishIps);
    }
}

// TRUSTED_PROXIES can be a CSV of hostnames
if (array_key_exists('TRUSTED_PROXIES', $_ENV)) {
   
    // Resolve to IPs, in case some/all of these hosts are round-robin DNS:
    $trustedProxiesHosts = explode(',', $_ENV['TRUSTED_PROXIES']);
    $trustedProxiesIps = array_filter(array_map(function($host) {
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

        return array_map(function($ip) use ($port) {
            return sprintf("%s:%s", $ip, $port);
        }, $ips);
    }, $trustedProxiesHosts));

    // Flatten 2d array
    if (!empty($trustedProxiesIps)) {
        $wgSquidServersNoPurge = call_user_func_array(array_merge, $trustedProxiesIps);
    }
}

// MEMCACHED_HOST can be a CSV of hostnames
if (array_key_exists('MEMCACHED_HOST', $_ENV)) {
    $wgMainCacheType = CACHE_MEMCACHED;
    
    // Resolve to IPs, in case some/all of these hosts are round-robin DNS:
    // We must be able to PURGE all memcache hosts
    $memcacheHosts = explode(',', $_ENV['MEMCACHED_HOST']);
    $memcacheIps = array_filter(array_map(function($host) {
        if (strpos($host, ':') === false) {
            $host .= ':11211';
        }

        // Preserve given port
        list($host, $port) = explode(':', $host);
        $ips = gethostbynamel($host) ?: [];

        return array_map(function($ip) use ($port) {
            return sprintf("%s:%s", $ip, $port);
        }, $ips);
    }, $memcacheHosts));

    // Flatten 2d array
    if (!empty($memcacheIps)) {
        $wgMemCachedServers = call_user_func_array(array_merge, $memcacheIps);
    }
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
    foreach($smtpEnvVars as $key => $val) {
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