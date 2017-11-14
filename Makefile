UNAME_S := $(shell uname -s)

.PHONY: build

help:
	@echo "Manages container build / deploy"

build:
	docker-compose build artifact

push:
	./build/push.sh