#!/bin/bash
task=$@  

if [ -z "$1" ]
  then
    task="idle"
fi

directory="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
timestamp=$(date +%s)
datestring=$(date -d @${timestamp})

echo "${timestamp},${task}" >> "${directory}/wip.csv"
echo "'${task}' started at ${datestring}"
