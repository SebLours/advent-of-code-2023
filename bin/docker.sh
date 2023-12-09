#!/bin/bash
docker run --rm --name=adventofcode_php -ti -v "$PWD":/app -w /app juliangut/phpdev:8.3 bash