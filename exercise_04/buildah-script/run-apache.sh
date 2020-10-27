#!/bin/bash
set -e

rm -rf /run/httpd/*

exec /usr/sbin/httpd -DFOREGROUND
