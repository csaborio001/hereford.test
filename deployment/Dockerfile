ARG WORDPRESS_IMAGE=wordpress:7.0.2-php8.3-apache
FROM ${WORDPRESS_IMAGE}
ENV WP_CLI_ALLOW_ROOT=true
RUN apt-get update && apt-get install -y --no-install-recommends default-mysql-client curl unzip git less && rm -rf /var/lib/apt/lists/*
RUN curl -fsSL https://github.com/wp-cli/wp-cli/releases/download/v2.12.0/wp-cli-2.12.0.phar -o /usr/local/bin/wp && chmod +x /usr/local/bin/wp && wp --info
RUN printf '[client]\nskip-ssl\n' > /etc/mysql/conf.d/local.cnf
RUN printf 'memory_limit=512M\nupload_max_filesize=128M\npost_max_size=128M\n' > /usr/local/etc/php/conf.d/project.ini
