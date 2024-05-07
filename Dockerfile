FROM ubuntu:latest
LABEL authors="renatocoronado"

ENTRYPOINT ["top", "-b"]