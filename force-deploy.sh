#/!bin/bash

local="sites/$1/dist"
if [ -z "$1" ] || [ ! -d "$local" ] ; then
  echo "you must pass a source folder. ('$1' is invalid, maybe missing './refresh-submodules.sh'?)"
  exit 1
fi

args="--delete"
if [ "$1" == "files" ] ; then
  args=""
fi

aws s3 sync "$local" "s3://fisherevans-com-content/hosted-content/$1" $args
