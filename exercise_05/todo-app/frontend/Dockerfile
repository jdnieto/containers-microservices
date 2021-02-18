FROM centos:7
MAINTAINER David Martín <david@aletiasoluciones.com>

LABEL version="1.0" PHP="7.1"

RUN yum install -y --setopt=tsflags=nodocs epel-release yum-utils http://rpms.remirepo.net/enterprise/remi-release-7.rpm httpd && \
	yum-config-manager --enable remi-php71 && \
	yum install -y --setopt=tsflags=nodocs php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-mysql && \
	mkdir /var/www/html/css

COPY css_content/ /var/www/html/css
COPY web_app /var/www/html/
COPY run-apache.sh /
EXPOSE 80

CMD /run-apache.sh
