FROM ubuntu:21.10

ENV APACHE_CONFDIR=/etc/apache2
ENV APACHE_ENVVARS=$APACHE_CONFDIR/envvars

WORKDIR /var/www/html

RUN apt update \
  && apt install -y apache2

COPY index.html var/www/html/

CMD ["apachectl", "-D", "FOREGROUND"]
#ENTRYPOINT [ "echo", "default" ]
#CMD [ "addcmd" ]
