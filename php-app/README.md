# php-app
This is a Dockerfile to build a php-app image and upload to docker.io.

## Build application image

Specify your credentials and your Docker repo (default is at docker.io) to build and push.

```
export DOCKER_USER=
unset HISTFILE; export DOCKER_PASSWORD=
docker login "docker.io" -u "${DOCKER_USER}" -p "${DOCKER_PASSWORD}"

export DOCKER_REPO=dotmartti/app
export DOCKER_TAG=$(cat TAG)

# to double-check you have set all 4 values properly
env | grep DOCKER

export DOCKER_TAG=$(cat TAG)
docker build -t "${DOCKER_REPO}:${DOCKER_TAG}" --target final .
docker push "${DOCKER_REPO}:${DOCKER_TAG}"
```
