include ./.env/wplocal-personal.env
SHELL=bash

sync:
	docker pull ghcr.io/crunchyintheory/wplocal-sync:latest
	mkdir -p .wplocal
	rsync -az $(SSH_USER)@$(SSH_HOST):$(REMOTE_WEBROOT)/wp-config.php ./.wplocal/wp-config.php
	sed -i '$$ d' ./.wplocal/wp-config.php
	rsync -azv --chmod=Du=rwx,Dg=rwx,Do=rx,Fu=rw,Fg=rw,Fo=r --exclude={'cache/*','uploads/backup/*','updraft/*'} $(SSH_USER)@$(SSH_HOST):$(REMOTE_WEBROOT)/wp-content ./.wplocal/
	docker run -u $(shell id -u):33 --rm -v $(shell pwd)/.wplocal/wp-content:/wp-content wordpress:$(WP_VERSION) chown -R $(shell id -u):33 /wp-content
	docker run -u $(shell id -u):$(shell getent group docker | cut -d: -f3) --rm -v $(shell pwd)/.wplocal:/wplocal ghcr.io/crunchyintheory/wplocal-sync:latest
	(source .wplocal/wplocal.env && ssh $(SSH_USER)@$(SSH_HOST) "mysqldump -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE > wplocal_dump.sql")
	rsync -az $(SSH_USER)@$(SSH_HOST):wplocal_dump.sql ./.wplocal/dump.sql

	[[ $(THEME_NAME) ]] && rm -r .wplocal/wp-content/themes/$(THEME_NAME)

migrate:
	source .wplocal/wplocal.env && \
	source .env/wplocal-personal.env && \
	cat .wplocal/migrate.sql | sed "s/wp_/$$WORDPRESS_TABLE_PREFIX/g" >> .wplocal/dump.sql && \
	docker compose exec db sh -c "mariadb -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE < ./dump.sql"

start:
	docker compose --env-file .env/wplocal-personal.env up -d

stop:
	docker compose down

down: stop

clean:
	docker volume prune
