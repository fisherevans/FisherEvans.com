#!/bin/bash

git submodule update --remote --merge

(cd submodules/metamorph && ./build.sh)
rm -rf sites/metamorph
mkdir -p sites/metamorph
mv submodules/metamorph/build sites/metamorph/dist
