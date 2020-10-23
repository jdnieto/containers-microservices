# Exercise 03: Images and Containers metadata
----------
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

