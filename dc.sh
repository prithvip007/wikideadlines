#!/bin/sh
export $(egrep -v '^#' .env | xargs)
docker-compose -f docker-compose.yml -f "docker-compose.${ENVIRONMENT}.yml" "$@"