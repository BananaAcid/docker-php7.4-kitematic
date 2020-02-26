# usage `make` or `make image` or `make run` or `make rmi`
# using `make`, use `make kill && make` to rebuild and run
all: image run

# build the image for distribution
image:
	docker build -t docker-php7.4-kitematic .

# test the image on port 8000
run:
	docker run -p 8000:80 -p 8443:443 -d docker-php7.4-kitematic

# just remove the image
rmi:
	docker rmi docker-php7.4-kitematic --force
	echo "reopen Kitematic (BETA) to update correctly"

# stop container and delete its image from docker
kill:
	docker rm `docker stop \`docker ps -a -q  --filter ancestor=docker-php7.4-kitematic\``
	#docker kill `docker ps -a -q  --filter ancestor=docker-php7.4-kitematic`
	docker rmi docker-php7.4-kitematic --force
	echo "reopen Kitematic (BETA) to update correctly"


# 1. make image, 2. login, 3. tag, 4. push
publish:
	make image && make login && make tag && make push

login:
	docker login

tag:
	docker tag docker-php7.4-kitematic bananaacid/docker-php7.4-kitematic

push:
	# for this, the image name has to be without the username until here
	docker push bananaacid/docker-php7.4-kitematic