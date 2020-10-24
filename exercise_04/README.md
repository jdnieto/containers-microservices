# Exercise 04: Building images
---------
## Committing containers
```bash
$ podman pull registry.centos.org/centos:8
$ podman run -it --name centos-httpd registry.centos.org/centos:8
[root@5e4812b39a4a /]# dnf install -y httpd --setopt=install_weak_deps=False --setopt=tsflags=nodocs
... omitted ...

[root@5e4812b39a4a /]# dnf clean all
[root@5e4812b39a4a /]# echo "My first httpd image" > /var/www/html/index.html
[root@5e4812b39a4a /]# exit

$ podman commit --change CMD="/usr/sbin/httpd -DFOREGROUND" --author "David Martin" centos-httpd my-httpd

$ podman images
REPOSITORY                         TAG      IMAGE ID       CREATED              SIZE
localhost/my-httpd                 latest   bd73308b4d2b   About a minute ago   244 MB

$ podman run -d --name my-httpd my-httpd

$ curl $(podman container inspect my-httpd -f '{{.NetworkSettings.IPAddress}}')
My first httpd image
```

## Use of Containerfile
```bash
$ cat Containerfile
FROM registry.centos.org/centos:8
LABEL author="David Martin" email="david@dmartin.es"

RUN dnf install -y httpd --setopt=install_weak_deps=False --setopt=tsflags=nodocs && dnf clean all

RUN sed -i 's/Listen .*/Listen 8080/g' /etc/httpd/conf/httpd.conf

COPY web-index.html /var/www/html/index.html

RUN useradd -u 10001 apache-user && \
    chgrp -R 10001 /var/www /run /var/log/httpd /var/lib/httpd && \
    chmod -R g=u /var/www /var/log/httpd /var/lib/httpd /run/

USER 10001

CMD ["/usr/sbin/httpd", "-DFOREGROUND"]


$ echo "containerfile sample" >> web-index.html

$ podman build -t built-httpd .

$ podman run -d --name built-httpd built-httpd

$ podman container inspect built-httpd -f '{{.NetworkSettings.IPAddress}}'
<container IP>

$ curl <ontainer IP>
```
