# Kubernetes Setup / Deploy

### Create Kubernetes Objects

* Edit kubernetes .yml files in the kubernetes/ folder to match your google gcr project and naming.  The files currently there are just a template and won't work out of the box for any other google project
* Edit the kubernetes/configmaps/env.yml to match the environment variables you want set in your web / worker containers

#### Create MySQL Database

* This project does not come with a MySQL container or associated kubernetes object. You should set up a Google Cloud MySQL instance and put it's credentials in the kubernetes/configmaps/env.yml file
* If you are using this for anything important you should use a Kubernetes secret object instead of a config map to secure your database credentials

#### Create Kubernetes Deployments
Create Redis / Web / Worker Deployments
```
kubectl create -f kubernetes/deployments
```

#### Create Kubernetes Configmaps
Create Web / Worker Environment Configmaps
```
kubectl create -f kubernetes/configmaps
```

#### Create Kubernetes Services
Create Redis / Web Services
```
kubectl create -f kubernetes/services
```

#### Create Kubernetes Ingress
Create Web Ingress
```
kubectl create -f kubernetes/ingresses
```

#### Confirm all pods are up and running
You should see a list showing "running" for all pods
```
kubectl get pods
```

#### View the running application
The ingress object can take a few minutes to finish provisioning. Once complete this command will show it's external IP address
```
kubectl get ingress horizon-demo-lb
```
Make sure to replace the ingress name with whatever you named it. Now you should be able to go to that public IP and view your application.
