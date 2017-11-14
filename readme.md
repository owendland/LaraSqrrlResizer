# LaraSqrrl Resizer

An application for resizing images of squirrels

### Getting Setup

#### Copy the .env.example file
```bash
cp .env.example .env 
```

#### Stand up the cli container
```bash
docker-compose up -d cli 
```

#### Install composer dependencies
```bash
docker-compose exec -T cli sh -cl "composer install"
```

#### Generate an application key
```bash
docker-compose exec -T cli sh -cl "php artisan key:generate"
```

#### Run database migrations
```bash
docker-compose exec -T cli sh -cl "php artisan migrate"
```

#### Create the storage folder symbolic link
```bash
docker-compose exec -T cli sh -cl "php artisan storage:link"
```

### Running the application

#### Stand up the web container
```bash
docker-compose up -d web
```

Access the application at <http://localhost>

### Running the application with Laravel Horizon
* Change your .env QUEUE_DRIVER=sync to QUEUE_DRIVER=redis

#### Stand up the worker container
```bash
docker-compose up -d worker
```

Access the horizon dashboard at <http://localhost/horizon>

Adding an image or deleting an image will now happen on a horizon worker which you can watch through the dashboard

### Build / Deploy Flow
Make sure to reference the readme.md at build/kubernetes/readme.md for reference on setting up deployment to Kubernetes

The build / deploy flow is driven by a top level Makefile. It has a help target that will describe the rest of the commands available.
```bash
make help
```
Here is it's output
```bash
Welcome to larasqrrl resizer!

usage: make [target]

misc:
  help                            Show this help.

workflow:
  build                           Build the artifact image and tag with latest
  push                            Push the latest artifact image to Google Container Registry
  deploy                          image=[full image:tag] Deploy artifact image to Kubernetes
```