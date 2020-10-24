#!/usr/bin/env bash

if [[ "$1" != REL1_* ]]; then
    echo "Usage: sh update-extensions-to.sh REL1_N"
    exit
fi

(
    cd src/extensions || exit
    for d in *; do
        (
            cd "$d" || exit
            git fetch origin || exit
            git checkout "origin/$1" || exit            
        )
    done
)