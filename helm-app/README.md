# Helm chart of a PHP + Postgres app

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