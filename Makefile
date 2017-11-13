UNAME_S := $(shell uname -s)

help:
	@echo "Manages container"

deploy:
	./build/deploy.sh