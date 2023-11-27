#!/bin/bash

set -e

npm run main
rm -rf ./dist
mv _src dist

optimizt .
