FROM python:3.6.4
MAINTAINER David Martín <david@aletiasoluciones.com>
# install packages
RUN apt-get update -yqq && apt-get install -yqq --no-install-recommends netcat mysql-client && apt-get -q clean
# add requirements
COPY ./requirements.txt /tmp/requirements.txt
# install requirements
RUN pip install -r /tmp/requirements.txt
COPY ./entrypoint.sh /usr/src/myapp/
COPY manage.py /usr/src/myapp/
COPY project /usr/src/myapp/project
# set working directory
WORKDIR /usr/src/myapp
# expose port 8080
EXPOSE 8080
# run server
ENTRYPOINT /usr/src/myapp/entrypoint.sh
