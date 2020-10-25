mediawiki: checkout-submodules
	docker build -t tfwiki/mediawiki:local .

tag:
	docker build -t tfwiki/mediawiki:${v} .

push: tag
	docker push tfwiki/mediawiki:${v}

run: mediawiki certs
	docker-compose up -d

checkout-submodules:
	git submodule init
	git submodule update

certs:
	openssl req -x509 \
		-newkey rsa:4096 \
		-nodes \
		-keyout certs/tfwiki.localhost.key \
		-out certs/tfwiki.localhost.crt \
		-days 30 \
		-subj '/CN=tfwiki.localhost'

.PHONY: certs