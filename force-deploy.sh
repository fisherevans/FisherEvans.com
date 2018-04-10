#/!bin/bash

local="sites/$1/dist"
if [ -z "$1" ] || [ ! -d "$local" ] ; then
  echo "you must pass a source folder. ('$1' is invalid)"
  exit 1
fi

aws s3 sync "$local" "s3://fisherevans-com/hosted-content/$1"