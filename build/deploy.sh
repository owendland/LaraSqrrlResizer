#!/usr/bin/env bash
set -e

SOURCE=gcr.io
PROJECT=horizon-demo-185900
DEPLOYMENT_PREFIX=horizon-demo
CONTAINER_NAME=horizon-demo-app

if [ -n "$1" ]
    then
    	IMAGE=$1
    else
    	echo "No image argument supplied for deploy"
        exit 1
fi

echo "Looking up image in GCR registry..."

if [[ "$(gcloud docker -- images ${IMAGE} | grep -v 'IMAGE' 2> /dev/null)" == "" ]];
	then
		echo "Failed to find image in GCE Registry, cancelling deploy..."
  		exit 1
fi

echo "Image found"

echo ""
echo "Deploying image - ${IMAGE}"

WEB_DEPLOYMENT=${DEPLOYMENT_PREFIX}-web
WEB_DEPLOY_COMMAND="kubectl set image deployment/${WEB_DEPLOYMENT} ${CONTAINER_NAME}=${IMAGE}"

echo ""
echo "Deploying web image:"
echo "${WEB_DEPLOY_COMMAND}"

${WEB_DEPLOY_COMMAND}

WORKER_DEPLOYMENT=${DEPLOYMENT_PREFIX}-worker
WORKER_DEPLOY_COMMAND="kubectl set image deployment/${WORKER_DEPLOYMENT} ${CONTAINER_NAME}=${IMAGE}"

echo ""
echo "Deploying worker image:"
echo "${WORKER_DEPLOY_COMMAND}"

${WORKER_DEPLOY_COMMAND}

echo ""
echo "Deployment complete!"

echo ""
echo "Run either of these commands to see the rollout status:"
echo "kubectl rollout status deployment/${WEB_DEPLOYMENT}"
echo "kubectl rollout status deployment/${WORKER_DEPLOYMENT}"