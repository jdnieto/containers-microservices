# Exercise 02: Working with podman
----------
## Search container images
```bash
$ podman search nginx
INDEX        NAME
centos.org   registry.centos.org/centos/nginx                 
... omitted ...
```

## Pull container image
```bash
$ podman pull registry.centos.org/centos/nginx
Trying to pull registry.centos.org/centos/nginx...
Getting image source signatures
Copying blob e6a50b627bcb skipped: already exists
Copying blob e7c9fbc2d902 done
Copying blob af724a6e8cd7 done
Copying blob 5fb3668ef438 done
Copying config 31e6c43e54 done
Writing manifest to image destination
Storing signatures
31e6c43e5485ddb41bf81d548bc966cd756bd41b0ba4f0c0b448337aec7e4ff0

$ podman images
REPOSITORY                         TAG      IMAGE ID       CREATED        SIZE
registry.centos.org/centos/nginx   latest   31e6c43e5485   9 months ago   410 MB
```

## Run container
```bash
$ podman run -d registry.centos.org/centos/nginx
932ebfbc92ddbcc234256ac12fbb127b1362438112657aa3e9a2eb94937db770

$ podman ps
CONTAINER ID  IMAGE                                    COMMAND  CREATED         STATUS             PORTS  NAMES
932ebfbc92dd  registry.centos.org/centos/nginx:latest  nginx18  21 seconds ago  Up 20 seconds ago         musing_mclean

$ podman inspect musing_mclean --format "{{.NetworkSettings.IPAddress}}"
10.88.0.22

$ curl 10.88.0.22:8080
nginx on CentOS7
```

## Remove container
```bash
$ podman stop musing_mclean
932ebfbc92ddbcc234256ac12fbb127b1362438112657aa3e9a2eb94937db770

$ podman rm  musing_mclean
932ebfbc92ddbcc234256ac12fbb127b1362438112657aa3e9a2eb94937db770
```
