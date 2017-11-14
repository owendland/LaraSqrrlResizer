UNAME_S := $(shell uname -s)

help:
	@echo "Manages container"

build:
	docker-compose build artifact

push:
	./build/push.sh