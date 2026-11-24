# PHP B-Tree in Docker.
#
# Every command runs in a new PHP container that is removed when the command
# ends. The project folder is shared with the container, so the dumps and
# images it makes show up in media/ on your machine.
# Run "make" or "make help" to see the commands.

# The image that compose.yaml builds for the project.
PROJECT_IMAGE = php-b-tree

# Base images from docker/php/Dockerfile. make remove deletes them too when
# Docker keeps them as images, so keep this list in step with the Dockerfile.
BASE_IMAGES = php:8.3-cli composer:2

# Runs one command in a new PHP container and removes the container after it.
RUN = docker compose run --rm php

# Your user and group id. The container writes files as you, not as root.
# With rootless Docker or Docker Desktop for Linux set both to 0,
# for example make btree HOST_UID=0 HOST_GID=0, see README.md.
export HOST_UID ?= $(shell id -u)
export HOST_GID ?= $(shell id -g)

# Turns the make btree values into bin/console flags and skips the empty ones.
# capacity=5 gives -c 5, set="1, 2" gives -s "1, 2", file=name.json gives
# -f name.json, graph=1 gives -g and dump=1 gives -d.
BTREE_FLAGS = $(if $(capacity),-c $(capacity)) \
              $(if $(set),-s "$(set)") \
              $(if $(file),-f $(file)) \
              $(if $(filter 1,$(graph)),-g) \
              $(if $(filter 1,$(dump)),-d)

# The full bin/console call that make btree runs in the container.
BTREE_COMMAND = $(RUN) php bin/console -t btree $(strip $(BTREE_FLAGS))

# Colors for the message that make btree prints at the end.
GREEN = \033[32m
RED   = \033[31m
RESET = \033[0m

# Shows the list of commands. Also runs when you call make without a command.
.PHONY: help
help:
	@echo "make help     show this list"
	@echo "make shell    open bash in the PHP container"
	@echo "make btree    build a B-tree, for example"
	@echo "              make btree capacity=5 set=\"1, 2, 3, 4\" graph=1 dump=1"
	@echo "              make btree file=num_set_exmpl.json graph=1"
	@echo "make remove   remove the containers, images, network and volumes of the project"
	@echo "make init     build the image and install the dependencies, runs by itself"

# Opens bash in the PHP container. Inside it you can run composer and
# bin/console with any flags.
.PHONY: shell
shell: init
	$(RUN) bash

# Builds a B-tree with bin/console. The image goes to media/graph,
# the dump goes to media/dump. First it shows the command it runs.
# At the end it shows the files it saved, or that bin/console stopped
# with an error. On an error make exits with a non-zero code too.
.PHONY: btree
btree: init
	@echo '$(BTREE_COMMAND)'
	@if $(BTREE_COMMAND); then \
		printf "\n  $(GREEN)✔ B-tree is ready$(RESET)\n\n"; \
		$(if $(filter 1,$(graph)),printf "    picture   %s\n" "$$(ls -t media/graph/*.jpeg 2>/dev/null | head -n 1)";) \
		$(if $(filter 1,$(dump)),printf "    dump      %s\n" "$$(ls -t media/dump/*.json 2>/dev/null | head -n 1)";) \
		$(if $(filter 1,$(graph) $(dump)),,printf "    nothing was saved, add graph=1 for a picture or dump=1 for a dump\n";) \
		printf "\n"; \
	else \
		printf "\n\n  $(RED)✘ B-tree failed$(RESET)\n\n"; \
		printf "    bin/console stopped with an error, read the message above\n"; \
		printf "    run make help to see how to call make btree\n\n"; \
		exit 1; \
	fi

# Removes what Docker made for the project: containers, the project image,
# the network and volumes. Project files and vendor/ stay.
# Then it removes the base images, if Docker keeps them as images and no other
# project uses them. Newer Docker keeps them only in its build cache, which is
# shared by all projects, so the cache stays. docker builder prune clears it.
.PHONY: remove
remove:
	docker compose down --rmi all --volumes --remove-orphans
	@docker image rm $(BASE_IMAGES) >/dev/null 2>&1 || true

# Prepares the project: builds the image and installs the composer packages.
# shell and btree call it by themselves, so there is no need to run it by hand.
# Its own line builds the image again when the image is missing but vendor/
# is in place, for example after make remove.
.PHONY: init
init: vendor/autoload.php
	@docker image inspect $(PROJECT_IMAGE) >/dev/null 2>&1 || docker compose build

# vendor/autoload.php is a real file that composer makes. Make treats it as
# proof that init is done and runs the commands below only when the file is
# missing or one of the files after the colon is newer. touch updates its date,
# because composer does not rewrite the file when nothing has changed.
vendor/autoload.php: composer.json composer.lock docker/php/Dockerfile docker/php/php.ini
	docker compose build
	$(RUN) composer install
	@touch $@
