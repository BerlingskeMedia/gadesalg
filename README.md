# Gadesalg

## Docker
Build and push a new image using:

```
docker build -t berlingskemedia/gadesalg .
docker push berlingskemedia/gadesalg
```

Start new instance using:

```
docker run \
--env=db_host=XXX \
--env=db_database=XXX \
--env=db_user=XXX \
--env=db_pass=XXX \
--publish=80:80 \
-d berlingskemedia/gadesalg
```

## Development and testing

Start a container with the source mounted onto the container.

```
docker run \
--env=db_host=XXX \
--env=db_database=XXX \
--env=db_user=XXX \
--env=db_pass=XXX \
--publish=80:80 \
-v /home/dako/Code/gadesalg/src:/var/www/html \
-d berlingskemedia/gadesalg
```
