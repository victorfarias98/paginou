.PHONY: up down build start stop restart ps logs shell composer npm artisan key migrate fresh seed tinker test clear

# Comandos Docker
up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

start:
	docker-compose start

stop:
	docker-compose stop

restart:
	docker-compose restart

ps:
	docker-compose ps

logs:
	docker-compose logs -f

# Comandos de desenvolvimento
shell:
	docker-compose exec app bash

composer:
	docker-compose exec app composer $(filter-out $@,$(MAKECMDGOALS))

npm:
	docker-compose exec app npm $(filter-out $@,$(MAKECMDGOALS))

artisan:
	docker-compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

# Comandos Laravel específicos
key:
	docker-compose exec app php artisan key:generate

migrate:
	docker-compose exec app php artisan migrate

fresh:
	docker-compose exec app php artisan migrate:fresh

seed:
	docker-compose exec app php artisan db:seed

tinker:
	docker-compose exec app php artisan tinker

test:
	docker-compose exec app php artisan test

clear:
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan view:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan optimize:clear
	docker-compose exec app composer dump-autoload

# Instalação inicial
install: up
	docker-compose exec app composer install
	docker-compose exec app npm install
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan storage:link

# Ajuda
help:
	@echo "Comandos disponíveis:"
	@echo "  make up           - Inicia os containers"
	@echo "  make down         - Para e remove os containers"
	@echo "  make build        - Reconstrói as imagens"
	@echo "  make start        - Inicia os containers parados"
	@echo "  make stop         - Para os containers"
	@echo "  make restart      - Reinicia os containers"
	@echo "  make ps           - Lista os containers"
	@echo "  make logs         - Mostra os logs"
	@echo "  make shell        - Acessa o shell do container app"
	@echo "  make composer     - Executa comandos do Composer"
	@echo "  make npm          - Executa comandos do NPM"
	@echo "  make artisan      - Executa comandos do Artisan"
	@echo "  make key          - Gera nova chave de aplicação"
	@echo "  make migrate      - Executa as migrações"
	@echo "  make fresh        - Recria o banco de dados"
	@echo "  make seed         - Executa os seeders"
	@echo "  make tinker       - Inicia o Tinker"
	@echo "  make test         - Executa os testes"
	@echo "  make clear        - Limpa cache e configurações"
	@echo "  make install      - Instalação inicial do projeto" 