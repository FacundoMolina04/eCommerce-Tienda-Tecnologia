#!/bin/bash
node="frontend/node_modules"

if [ -f gamerland.zip ]
then
  rm gamerland.zip
fi

zip -r gamerland.zip ./ -x "$node/*"
