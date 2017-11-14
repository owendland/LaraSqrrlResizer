# LaraSqrrl Resizer

An application for resizing images of squirrels

## Getting Setup

### Copy the .env.example file
```bash
cp .env.example .env 
```

### Stand up the cli container
```bash
docker-compose up -d cli 
```

### Install composer dependencies
```bash
docker-compose exec -T cli sh -cl "composer install"
```

### Generate an application key
```bash
docker-compose exec -T cli sh -cl "php artisan key:generate"
```

### Run database migrations
```bash
docker-compose exec -T cli sh -cl "php artisan migrate"
```

### Create the storage folder symbolic link
```bash
docker-compose exec -T cli sh -cl "php artisan storage:link"
```

## Running the application

### Stand up the web container
```bash
docker-compose up -d web
```

Access the application at <http://localhost>
