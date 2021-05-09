# Helm chart of a PHP + Postgres app

## Test existing installation
```
curl http://35.228.234.91/ -H "Host: whatever.io"
```


## Prerequisites
* `kubectl` configured with your K8s cluster
* Helm v3 installed
* The application Docker image built and uploaded

## How to
Change the secret values, namespace name and template name to your liking and install.

```
git clone https://github.com/dotmartti/helm-php.git
cd helm-app/

# create a namespace for the application and make it your default
kubectl create namespace dev
kubens dev

# pull down library charts
helm dep up

# check all the generated manifests with your secret values
helm template . --name-template=testenv --set email.user=martti.remmelgas@gmail.com,email.pw=gmail-app-pass,pg.postgresqlPassword=bzzz123,pg.postgresqlPostgresPassword=bzzzadmin123

# install the chart to your active K8s namespace
helm install . --name-template=testenv --set email.user=martti.remmelgas@gmail.com,email.pw=gmail-app-pass,pg.postgresqlPassword=bzzz123,pg.postgresqlPostgresPassword=bzzzadmin123
```

### Upgrade existing release
Using the existing variables
```
helm upgrade testenv .
```

### Delete existing release
Using the existing variables
```
helm delete testenv
```


### Prerequisite: Setup GKE cluster
You should have a Kubernetes cluster somewhere. In this case let's say in Google cloud.

* There you need to work in the context of one "project". 
* Set up your favorite region and zone where you will deploy the cluster.
* Enable an API feature for GKE
* Select how many worker nodes you need

```
# SETUP cluster
gcloud config set project <your project>
gcloud config set compute/region europe-north1
gcloud config set compute/zone europe-north1-c
gcloud compute zones describe europe-north1-c
gcloud config list project
gcloud services enable container.googleapis.com

# CREATE
gcloud container clusters create mrt-cluster --num-nodes 3
gcloud compute instances list


# DELETE your cluster to clean up afterwards
gcloud container clusters delete mrt-cluster
```



### Prerequisite: Install Nginx Ingress controller
```
helm repo add nginx-stable https://helm.nginx.com/stable
helm repo update
helm install nginx-ingress nginx-stable/nginx-ingress
kubectl get deployment nginx-ingress-nginx-ingress
kubectl get service nginx-ingress-nginx-ingress
export NGINX_INGRESS_IP=$(kubectl get service nginx-ingress-nginx-ingress -ojson | jq -r '.status.loadBalancer.ingress[].ip')
sleep 30 && echo "Your external IP: $NGINX_INGRESS_IP"
```



### Prerequisite: To use Gmail to send email, create an App Password
I hope you have 2FA (2-Step-Verification) enabled for your Google Account. To use that same account for sending an email from your app, you need to create an alternative limited password that Google calls an "App Password". 

https://support.google.com/accounts/answer/185833

https://myaccount.google.com/ > Security > App Passwords > enter an app and device > Generate

Use that value for Helm chart's **email.pw**=*pass*.
