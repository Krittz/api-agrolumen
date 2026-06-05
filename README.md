# AgroLumen API

Backend da plataforma AgroLumen.

O AgroLumen é um sistema de gestão voltado para produtores rurais, com foco inicial no controle da produção leiteira, propriedades, rebanho e indicadores operacionais.

---

## Tecnologias

- PHP 8.3
- Slim Framework 4
- MySQL 8.4
- Nginx
- Docker
- Docker Compose
- Monolog
- PHP-DI

---

## Estrutura do Projeto

```text
backend/
├── app/
├── public/
├── src/
├── tests/
├── logs/
├── vendor/
├── composer.json
└── Dockerfile
```

---

## Requisitos

- Docker
- Docker Compose

---

## Executando o Ambiente

Na raiz do projeto:

```bash
docker compose up -d --build
```

Verificar containers:

```bash
docker ps
```

---

## Health Check

```http
GET /health
```

Resposta esperada:

```json
OK
```

---

## Variáveis de Ambiente

As configurações são carregadas através do arquivo:

```text
.env
```

Exemplo:

```env
APP_ENV=local

DB_HOST=agrolumen_db
DB_PORT=3306
DB_DATABASE=agrolumen
DB_USERNAME=agrolumen
DB_PASSWORD=secret
```

---

## Banco de Dados

O banco MySQL é executado em container Docker.

O serviço utiliza o hostname:

```text
agrolumen_db
```

dentro da rede Docker.

---

## Logs

Os logs da aplicação ficam disponíveis em:

```text
logs/
```

ou no stdout do container quando executado em ambiente Docker.

Visualizar logs:

```bash
docker logs -f agrolumen_api
```

---

## Desenvolvimento

O código-fonte é montado como volume Docker.

Alterações em:

```text
src/
app/
public/
```

são refletidas automaticamente sem necessidade de rebuild da imagem.

Rebuild é necessário apenas quando houver alterações em:

- Dockerfile
- composer.json
- composer.lock
- Dependências do sistema operacional

---

## Licença

Projeto privado.
Todos os direitos reservados.