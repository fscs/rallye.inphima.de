IMAGE ?= registry.hhu-fscs.de/rallye.inphima.de
TAG ?= $(shell git rev-parse --short HEAD)

FULL_TAG ?= $(IMAGE):$(TAG)

BUILD_ARGS ?= -t $(IMAGE)

default: docker-build

docker-build:
	docker build $(BUILD_ARGS) .
	docker tag $(IMAGE) $(FULL_TAG)
.PHONY: docker-build

docker-push: docker-build
	docker push $(IMAGE)
	docker push $(FULL_TAG)

