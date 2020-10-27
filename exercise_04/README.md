# Exercise 04: Building images
---------
## Podman
### Committing containers
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

### Containerfile (aka Dockerfile)
```bash
$ cat Containerfile
FROM registry.centos.org/centos:8
LABEL author="David Martin <david@dmartin.es>" \
      description="Simple httpd image built with Containerfile"

RUN dnf install -y httpd --setopt=install_weak_deps=False --setopt=tsflags=nodocs && \
    useradd -u 10001 httpd-user && \
    chgrp -R httpd-user /var/lib/httpd /var/www/ /var/log/httpd /run/httpd && \
    chmod -R g=u /var/lib/httpd /var/www/ /var/log/httpd /run/httpd

COPY web.html /var/www/html/index.html

RUN sed -i 's/Listen.*/Listen 8080/' /etc/httpd/conf/httpd.conf

USER httpd-user

CMD ["/usr/sbin/httpd", "-DFOREGROUND"]


$ echo 'It works!' > web.html

$ podman build -t httpd-file .
STEP 1: FROM registry.centos.org/centos:8
... omitted ...


$ podman run -d --name httpd-file localhost/httpd-file
29c95b493bb3536f64a8f3805f18462886a20c04431fe29e5b423f3d14264fdb

$ curl $(podman container inspect httpd-file -f '{{.NetworkSettings.IPAddress}}'):8080
It works!

```

## buildah
### Installation
```bash
$ dnf install -y buildah
```

### buildah Containerfile
```bash
$ buildah bud -t buildah-file .

STEP 1: FROM registry.centos.org/centos:8
... omitted ...
```

### First buildah container
```bash
$ buildah from centos:8
... omitted ...

$ buildah containers
... omitted ...

$ buildah run centos-working-container bash

[root@0e3ea9423259 /]# dnf install -y httpd --setopt=install_weak_deps=False --setopt=tsflags=nodocs
... omitted ...
[root@0e3ea9423259 /]# dnf clean all
[root@0e3ea9423259 /]# exit

$ buildah copy centos-working-container web.html /var/www/html/index.html

$ buildah config --cmd "/usr/sbin/httpd -DFOREGROUND" --author "David Martin <david@dmartin.es" centos-working-container

$ buildah commit centos-working-container buildah-httpd

```
