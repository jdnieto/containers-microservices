# Exercise 03: Containers metadata
---------
## Inspecting images
```bash
$ podman inspect registry.centos.org/centos/httpd
[
    {
        "Id": "6f2ecea8c21f56df0b1d82c347cb560fe5af540c0411d39e7d99799ba137be10",
        "Digest": "sha256:5cfc740200027b20cdd023518ae49261d9ee053b52e4423aad12c719fc478f89",
        "RepoTags": [
            "registry.centos.org/centos/httpd:latest"
        ],
        "RepoDigests": [
            "registry.centos.org/centos/httpd@sha256:5cfc740200027b20cdd023518ae49261d9ee053b52e4423aad12c719fc478f89"
... omitted ...
```

## Inspecting containers
```bash
$ podman run --name demo-web --detach registry.centos.org/centos/httpd
$ podman inspect demo-web
[
    {
        "Id": "a19902b727db643b8f5f5b1ce7967e390cf8ed38f5cee0c157860ff06a6abeff",
        "Created": "2020-10-24T10:51:47.782276181+02:00",
        "Path": "/run-httpd.sh",
        "Args": [
            "/run-httpd.sh"
        ],
... omitted ...

$ podman inspect --format 'Base_Image: {{.ImageName}}   ||   Container_IP: {{.NetworkSettings.IPAddress}}' demo-web
Base_Image:   registry.centos.org/centos/httpd:latest         ||         Container_IP:   10.88.0.23
```

## Avoid confusing image name and container
```bash
$ podman image inspect <image-name>
$ podman container inspect <container-name>
```

## Inspecting host
```bash
$ podman system info
host:
  BuildahVersion: 1.12.0-dev
  CgroupVersion: v1
  Conmon:
    package: conmon-2.0.6-1.module_el8.2.0+305+5e198a41.x86_64
    path: /usr/bin/conmon
    version: 'conmon version 2.0.6, commit: a2b11288060ebd7abd20e0b4eb1a834bbf0aec3e'
  Distribution:
    distribution: '"centos"'
    version: "8"
  MemFree: 995196928
  MemTotal: 1555017728
... omitted ...

$ podman system df
TYPE            TOTAL   ACTIVE   SIZE     RECLAIMABLE
Images          11      5        2.38GB   1.96GB (82%)
Containers      6       1        277kB    276kB (99%)
Local Volumes   0       1        0B       0B (0%)
```
