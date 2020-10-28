#!/bin/bash
set -e

rm -rf /run/httpd/* /tmp/*

exec /usr/sbin/httpd -DFOREGROUND
