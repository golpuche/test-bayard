init:
	docker compose build
	docker compose up -d
	docker compose cp php:/app/vendor vendor
	docker compose run php sh -c "bin/console fixtures:load"

test:
	docker compose run php sh -c "bin/phpunit"