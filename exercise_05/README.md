# Exercise 05: Deploying Applications
---------
## Manually by IP
```bash
# Database
$ podman volume create db
$ podman run -d --name database -v db:/var/lib/mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=myp455 -e MYSQL_DATABASE=tareas database

$ mysql -uroot -pmyp455 -h127.0.0.1 tareas -e 'insert into tareas(tareas) values(\'first\'); select * from tareas'

# Backend
$ podman container inspect database -f '{{.NetworkSettings.IPAddress}}'
10.88.0.35

$ podman run -d --name backend -e APP_SETTINGS=project.DevelopmentConfig -e API_KEY=test -e DATABASE_URL='mysql+pymysql://root:myp455@10.88.0.35/tareas' -e DATABASE_HOST=10.88.0.35 -p 8080:8080 backend

# Frontend
$ podman container inspect backend -f '{{.NetworkSettings.IPAddress}}'
10.88.0.57

$ podman run -d --name frontend -p 80:80 -e BACKEND_HOST=10.88.0.57:8080 -e API_KEY=test frontend
```

## dnsname plugin
```bash
$ dnf install -y git dnsmasq golang
$ dnf groupinstall -y "Development Tools"

$ git clone https://github.com/containers/dnsname
$ cd dnsname
$ make
$ make install PREFIX=/usr

# Edit cni
$ cat /etc/cni/net.d/87-podman-bridge.conflist
... omitted ...
 "plugins": [
	... omitted ..
	{
	  "type": "dnsname",
	  "domainName": "test.io"
	}
... omitted ...

# Database
$ podman run -d --name database -v db:/var/lib/mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=myp455 -e MYSQL_DATABASE=tareas database

# Backend
$ podman run -d --name backend -e APP_SETTINGS=project.DevelopmentConfig -e API_KEY=test -e DATABASE_URL='mysql+pymysql://root:myp455@database.test.io/tareas' -e DATABASE_HOST=database.test.io -p 8080:8080 backend

# Frontend
$ podman run -d --name frontend -p 80:80 -e BACKEND_HOST=backend.test.io:8080 -e API_KEY=test frontend
```

## pod definition
```bash
$ podman play kube pod.yaml
```

## bootstrapping
```bash
# Define a template with parameters, and define parameters in env files (see all files with a "dot(.)")
# Proccess template via scripting
$ ./bootstrap.sh <template-filename> <env-file>
```

