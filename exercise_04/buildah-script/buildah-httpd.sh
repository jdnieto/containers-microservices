#!/bin/bash
set -o

#checking buildah
if ! hash buildah &>/dev/null
then
	echo "buildah is not installed. Exiting."
	exit 1
fi
if [ ! -f /etc/redhat-release ]
then
	echo "This script only works with EL 8 family. Exiting."
	exit 2
fi

# Create buildah container
container=$(buildah from scratch)
echo "Working on container : $container"

#Mount container filesystem locally
mount=$(buildah mount $container)
echo "Mounting directory: $mount"

# Installing Apache 2 in container
dnf --installroot $mount --release 8 install -y httpd \
    --setopt=install_weak_deps=False --setopt=tsflags=nodocs --setopt=tsflags=nocontexts
dnf --installroot $mount --release 8 clean all

# Copy index file
cp web.html ${mount}/var/www/html/index.html

# Copy entrypoint scripts
cp container-entrypoint.sh run-apache.sh ${mount}/

# Create httpd-user and fix permissions
chroot ${mount}/ /bin/bash <<"EOT"
useradd httpd-user -u 10001
chgrp -R httpd-user /var/lib/httpd /var/www /var/log/httpd /run/httpd
chmod -R g=u /var/lib/httpd /var/www /var/log/httpd /run/httpd
sed -i 's/Listen.*/Listen 8080/' /etc/httpd/conf/httpd.conf
EOT

# Create image metadata
buildah config \
  --label maintainer="David Martin <david@dmartin.es>"  \
  --label distribution="centos" \
  --label version="8" \
  --label description="This image is intended to demonstrate image creation based on buildah" \
  --env PATH=$PATH:/ \
  --env NAME=httpd \
  --port 8080 \
  --user httpd-user \
  --entrypoint '["/container-entrypoint.sh"]' \
  --cmd "run-apache.sh" $container

# Commit image
buildah commit $container buildah-httpd:2.0
