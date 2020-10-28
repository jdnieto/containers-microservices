#!/bin/bash
#set -x
TEMPLATE=$1
ENVIRONMENT=${2:-env}
source .${ENVIRONMENT}
if [ ! -d $DB_DIR ];
then
	mkdir $DB_DIR
fi
chmod 777 $DB_DIR
TMP_DIR=$(mktemp -d)
eval "cat <<EOF
$(<$TEMPLATE)
EOF
" 1> ${TMP_DIR}/pod.yml  2> /dev/null
podman play kube ${TMP_DIR}/pod.yml
rm -rf ${TMP_DIR}
