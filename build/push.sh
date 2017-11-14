#!/usr/bin/env bash
set -e

APP=lara-sqrrl-resizer

SOURCE=gcr.io
PROJECT=horizon-demo-185900

REPO=${SOURCE}/${PROJECT}/${APP}

BRANCH=$(git rev-parse --abbrev-ref HEAD)
SHORT_REVISION=$(git rev-parse --short HEAD)
DOCKER_TAG=$(echo "${BRANCH}.${SHORT_REVISION}" | tr '/' '-' | tr -dc '[:alnum:]\n-._')

IMAGE=${REPO}:${DOCKER_TAG}
LATEST_IMAGE=${REPO}:latest

### Tag the container with the git branch and commit hash ###
echo docker tag \"${REPO}\" \"${IMAGE}\"

docker tag "${REPO}" "${IMAGE}"

### Push up the container ###
echo gcloud docker -- push \"${IMAGE}\"

gcloud docker -- push "${IMAGE}"

DOCKER_TAG_STRING=${DOCKER_TAG}

### For master branch, also update with 'latest' tag ###
if [ ${BRANCH} = "master" ]; then
	echo ""
	echo "Master branch detected: also tagging as 'latest'"

	### Tag the container as latest ###
	echo docker tag \"${REPO}\" \"${LATEST_IMAGE}\"

	docker tag "${REPO}" "${LATEST_IMAGE}"

	### Push the updated latest tag ###
	echo gcloud docker -- push \"${LATEST_IMAGE}\"

	gcloud docker -- push "${LATEST_IMAGE}"

	DOCKER_TAG_STRING=${DOCKER_TAG}\|latest
fi

URL="https://console.cloud.google.com/kubernetes/images/tags/${APP}-service?location=US&project=${PROJECT}"

echo ""
echo "New image pushed to container registry [${DOCKER_TAG_STRING}]"
echo "Image: ${IMAGE}"
echo "URL:   ${URL}"