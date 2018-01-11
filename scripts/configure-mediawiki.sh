#!/bin/bash

# No configuration is actually needed as environmental variables are
# interpreted at runtime.
# We do want to crash early if required environmental variables are missing.

required_vars=( CAPTCHA_SECRET DB_DATABASE DB_HOST DB_TYPE DB_USER SECRET_KEY SERVER_URL SITENAME )
missing_vars=
current_var=

# If any SMTP variables are set, we require the EMAIL_* vars
smtp_vars=( SMTP_AUTH SMTP_HOST SMTP_IDHOST SMTP_PASSWORD SMTP_PORT SMTP_USERNAME )
smtp_vars_present=

for smtp_var in "${smtp_vars[@]}"
do
    eval current_var=\$$smtp_var
    if [ ! -z "$current_var" ] && [ smtp_vars_present != true ] ; then
        smtp_vars_present=true
        required_vars=( "${foo[@]}" EMAIL_EMERGENCY_CONTACT EMAIL_PASSWORD_SENDER )
    fi
done

# Flag any missing required vars
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