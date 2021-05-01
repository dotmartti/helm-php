# helm-php
Tinkering around with a PHP app, deployed by Helm3 to GKE.

## Overview

* PHP application code in php-app/app/ dir
* Application packaged into a Docker image defined in the php-app/Dockerfile
* Deployed to a Kubernetes cluster via the Helm chart in helm-app/ dir


## Local dev env

Tools 
* docker
* kubectl 
* helm v3
* Docker Hub account to upload your application images
