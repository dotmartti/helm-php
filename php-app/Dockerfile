FROM bitnami/php-fpm:8.0 as final

# install some tools - in a single layer
RUN apt-get update \
    && apt-get install -y \
        dnsutils=1:9.11.5.P4+dfsg-5.1+deb10u5 \
        msmtp=1.8.3-1 \
        net-tools=1.60+git20180626.aebd88e-1 \
        netcat-openbsd=1.195-2 \
        postgresql-client-11=11.11-0+deb10u1 \
    && apt-get clean \
    && rm -fr /var/lib/apt/lists/*

# php conf
COPY php-app.conf /opt/bitnami/php/etc/php-fpm.d/www.conf
COPY php.ini /opt/bitnami/php/etc/php.ini

# the PHP application
COPY app /app

# The application's directory will be the working directory
WORKDIR /app
