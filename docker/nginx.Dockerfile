# "mongo" stage
FROM nginx:1.14.2 AS nginx

LABEL MAINTAINER Alexandre ANDRE <a.andre@prohacktive.io>

## @aandre 20230503 : Debian Stretch is deleted from http://security.debian.org/debian-security/
RUN sed -i s/deb.debian.org/archive.debian.org/g /etc/apt/sources.list
RUN sed -i 's|security.debian.org|archive.debian.org/|g' /etc/apt/sources.list
RUN sed -i '/stretch-updates/d' /etc/apt/sources.list

# Install dependencies
RUN apt-get update && apt-get install -y curl && apt-get clean
