#!/usr/bin/env bash
[[ ! -z ${DEBUG} ]] && set -x

info () {
#  [[ ! -z "${VERBOSE}" ]] && printf "\033[0;36m===> \033[0;33m%s\033[0m\n" "$1" 1>&2
  printf "\033[0;36m===> \033[0;33m%s\033[0m\n" "$1" 1>&2
}

error () {
  printf "\033[0;36m===> \033[49;31m%s\033[0m\n" "$1" 1>&2
}

setEnvironmentVariables() {
    BASH_RC_FILE="/home/www-data/.bashrc"

    echo "alias phpdebug='XDEBUG_CONFIG="idekey=PHPSTORM" PHP_IDE_CONFIG="serverName=web-dev" php'" >>  $BASH_RC_FILE
    echo "alias phpdebugartisan='XDEBUG_CONFIG="idekey=PHPSTORM" PHP_IDE_CONFIG="serverName=web-dev" php -d memory_limit=-1 /var/www/artisan'" >>  $BASH_RC_FILE
    echo "alias artisan='php -d memory_limit=-1 /var/www/artisan'" >>  $BASH_RC_FILE
    echo "alias composer='php -d memory_limit=-1 /usr/local/bin/composer'" >>  $BASH_RC_FILE

    info "Aliases Added"
}

nginxConfig() {
    local filePath=/etc/nginx/conf.d/host.conf

    # application entry
    if [[ ${ENV} != "prod" ]]; then
        sed -i "s/{{ENVIRONMENT_ENTRY_POINT}}/index.php/g" ${filePath}
    else
        sed -i "s/{{ENVIRONMENT_ENTRY_POINT}}/index.php/g" ${filePath}
    fi

    # server name (domain)
    sed -i "s/{{SERVER_NAME}}/_/g" ${filePath}
}

XDebugConfig() {

    # If xdebug disabled remove xdebug.ini
    if [[ ! -z ${XDEBUG_ENABLED} ]] && [[ ${#XDEBUG_ENABLED} -gt 0 ]] && [[ ${XDEBUG_ENABLED} != "false" ]] && [[ ${XDEBUG_ENABLED} != "0" ]]; then

      DOCKER_HOST_IP=$(/sbin/ip route|awk '/default/ { print $3 }')
      XDEBUG_FILE_PATH="/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
      sed -i -e 's/^;zend_extension/\zend_extension/g' $XDEBUG_FILE_PATH

      echo "xdebug.remote_enable=on" >>  $XDEBUG_FILE_PATH
      echo "xdebug.remote_host=${DOCKER_HOST_IP}" >> $XDEBUG_FILE_PATH
      echo "xdebug.remote_port=9000" >> $XDEBUG_FILE_PATH
      echo "xdebug.remote_handler=dbgp" >> $XDEBUG_FILE_PATH
      echo "xdebug.max_nesting_level=500" >>  $XDEBUG_FILE_PATH
      echo "xdebug.profiler_enable_trigger=1" >>  $XDEBUG_FILE_PATH
      echo "xdebug.profiler_output_dir=/var/www/app/logs" >>  $XDEBUG_FILE_PATH

      info "Xdebug enabled"

    else
      if [[ $(find /usr/local/etc/php/conf.d | grep -c "xdebug.ini") -gt 0 ]]; then
        rm /usr/local/etc/php/conf.d/*-xdebug.ini
      fi
      info "Xdebug disabled"
    fi
}

OPCacheConfig() {
    # If OPCACHE disabled remove xdebug.ini
    if [[ ! -z ${OPCACHE_ENABLED} ]] && [[ ${#OPCACHE_ENABLED} -gt 0 ]] && [[ ${OPCACHE_ENABLED} != "false" ]] && [[ ${OPCACHE_ENABLED} != "0" ]]; then
      info "OpCache enabled"
    else
      if [[ $(find /usr/local/etc/php/conf.d | grep -c "opcache.ini") -gt 0 ]]; then
        rm /usr/local/etc/php/conf.d/*-opcache.ini
      fi
      info "OpCache disabled"
    fi

}

# The service that keeps other services alive
initSupervisor() {
    #start supervisor
    /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf &
    info "Supervisor enabled"
}


# add cron
initCron() {
    echo "* * * * * sudo -u www-data php -d memory_limit=-1  /var/www/artisan schedule:run 1>> /dev/null 2>&1" | crontab -u root -
    info "Cron enabled"
}

initApp() {

    if [ ! -d "/var/www/vendor" ]; then
        rm -Rf /var/www/vendor/*
        cd /var/www
        sudo -u www-data php -d memory_limit=-1 /usr/local/bin/composer install
    fi

    chown -Rf www-data:www-data /var/www

    /var/www/artisan  migrate
    /var/www/artisan  cache:clear

}

if [[ $1 == "-d" ]]; then
    setEnvironmentVariables
    nginxConfig
    XDebugConfig
    OPCacheConfig
    initApp
    initCron
    initSupervisor
    while true; do sleep 1000; done
else
  exec "$@"
fi