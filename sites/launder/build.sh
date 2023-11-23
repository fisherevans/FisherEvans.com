#!/bin/bash

rm -rf dist
cd app
npm run build
mv build ../dist
