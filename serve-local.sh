#!/bin/bash

local="sites/$1/dist"
if [ -z "$1" ] || [ ! -d "$local" ] ; then
  echo "you must pass a source folder. ('$1' is invalid)"
  exit 1
fi

cd "$local"

port=8000
echo "Serving $local on http://localhost:$port"

python -m SimpleHTTPServer "$port"