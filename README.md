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



## App features

### Feature 1

Square the parameter n and you will get your answer as plain text, no HTML.

To test the app, use the external IP
```
curl -v http://35.228.234.91/?n=4 -H "Host: whatever.io"
...
< HTTP/1.1 200 OK
16
```


### Feature 2

* HTTP result will be 444
* Visitor will be blocked from doing anything in /blacklisted endpoint
* Application endpoint /blacklisted will result in your IP added to "blocklist" table. 
* TODO: send an email with the IP address to test@domain.com


To test the app, use the external IP
```
curl -v http://35.228.234.91/blacklisted -H "Host: whatever.io"
...
< HTTP/1.1 444
```

Looking into DB via the application Pod.
```
$ kubectl exec -it testenv-helm-app-7cb57fbbc6-4fnp5 -c app -- bash
root@testenv-helm-app-7cb57fbbc6-4fnp5:/app# psql
psql (11.11 (Debian 11.11-0+deb10u1))
Type "help" for help.

paxdb=> select * from blocklist;
      ip      |     path     |         timestamp          
--------------+--------------+----------------------------
 127.0.0.1    | /blacklisted | 2021-05-02 22:03:10.363712
 84.50.131.75 | /blacklisted | 2021-05-02 23:19:22.684096
 ```
