FROM ubuntu:22.04

RUN apt update \
  && apt install -y apache2

CMD ["apachectl", "-D", "FOREGROUND"]
