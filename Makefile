UNAME_S := $(shell uname -s)

help:
	@echo "Manages container"

push:
	./build/push.sh