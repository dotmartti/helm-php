# Helm chart of a PHP + Postgres app

## Test existing installation
'''
curl http://35.228.234.91/ -H "Host: whatever.io"
'''


## Prerequisites
* 'kubectl' configured with your K8s cluster
* Helm v3 installed
* The application Docker image built and uploaded

## How to
Change the secret values, namespace name and template name to your liking and install.

'''
git clone https://github.com/dotmartti/helm-php.git
cd helm-app/

# create a namespace for the application and make it your default
kubectl create namespace dev
kubens dev

# pull down library charts
helm dep up

# check all the generated manifests with your secret values
helm template . --name-template=testenv --set pg.postgresqlPassword=bzzz123,pg.postgresqlPostgresPassword=bzzzadmin123

# install the chart to your active K8s namespace
helm install . --name-template=testenv --set pg.postgresqlPassword=bzzz123,pg.postgresqlPostgresPassword=bzzzadmin123
'''

### Upgrade existing release
Using the existing variables
'''
helm upgrade testenv .
'''

### Delete existing release
Using the existing variables
'''
helm delete testenv
'''


### Prerequisite: Install Nginx Ingress controller
'''
helm repo add nginx-stable https://helm.nginx.com/stable
helm repo update
helm install nginx-ingress nginx-stable/nginx-ingress
kubectl get deployment nginx-ingress-nginx-ingress
kubectl get service nginx-ingress-nginx-ingress
export NGINX_INGRESS_IP=$(kubectl get service nginx-ingress-nginx-ingress -ojson | jq -r '.status.loadBalancer.ingress[].ip')
echo $NGINX_INGRESS_IP
'''

As a current temporary workaround, use the $NGINX_INGRESS_IP value in values.yaml ingress.dns definition.