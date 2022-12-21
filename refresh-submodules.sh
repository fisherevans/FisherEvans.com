#!/bin/bash

git submodule update --remote --merge

(cd submodules/metamorph && ./build.sh)
mkdir sites/metamorph/dist
mv submodules/metamorph/build ../../sites/metamorph/dist
