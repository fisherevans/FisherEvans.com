#!/bin/bash

git submodule update --remote --merge

if [ "$1" == "" ] || [ "$1" == "metamorph" ] ; then 
  (cd submodules/metamorph && ./build.sh)
  rm -rf sites/metamorph
  mkdir -p sites/metamorph
  cp -r submodules/metamorph/build sites/metamorph/dist
fi

if [ "$1" == "" ] || [ "$1" == "resume" ] ; then
  rm -rf sites/resume
  mkdir -p sites/resume
  cp -r submodules/resume/dist sites/resume
fi

if [ "$1" == "" ] || [ "$1" == "stealing-from-santa" ] ; then
  (cd submodules/stealing-from-santa && ./build.sh)
  rm -rf sites/stealing-from-santa
  mkdir -p sites/stealing-from-santa
  cp -r submodules/stealing-from-santa/web sites/stealing-from-santa/dist
fi
