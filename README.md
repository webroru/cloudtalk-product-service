## Assignment Description

Your task is to build a two service system for product reviews.

Product service will expose RESTful API interfaces for manipulation with products and reviews.

Review processing service will handle calculation of average review product rating.

You are free to use any frameworks, databases, caching mechanisms and messaging brokers to develop a solution. However, taking into account the position, use PHP in combination with node.js.

---

## Service 1: Product service

- **RESTful API for products** with create, delete, edit, list and get by identifier actions
    - product information should **not return reviews**, only average product rating
- **RESTful API for reviews** with create, delete and edit actions
- **Endpoints to show product reviews**
- **Service should notify review service** when new review is added, modified or deleted

---

## Service 2: Review processing service

- Service receives events from product service
- Each time review is received, it calculates average rating and stores it into persistent storage
- Running in **2 separate instances**
    - design must be able to handle more than 2 instances
- Service must be able to **process multiple events concurrently**

**Note:** Product reviews and average product ratings should be cached.

---

## Product structure

- name
- description
- price
- list of reviews
- average rating (does not have to be directly a part of product)

---

## Review structure

- first name
- last name
- review text
- rating (1 - 5)

---

## Architecture diagram

![Architecture diagram](./diagram.png)

(source file: [diagram.puml](./diagram.puml))

## Production deployment

- To run in production mode, use
  ```bash 
  docker-compose -f docker-compose.prod.yml up -d
  ```
- Execute migrations in product service container
  ```bash
  docker-compose -f docker-compose.prod.yml exec php bin/console doctrine:migrations:migrate --no-interaction
  ```
- Execute migrations in review processing service container
  ```bash
  docker-compose -f docker-compose.prod.yml exec nodejs npm run migration:run -- -d ./data-source.ts
  ```

## Usage

You can use [product.http](product.http) and [reviews.http](reviews.http) files to test the services.

## Architectural Decisions and Rationale

## 1. CQRS is Applied — Separation of Reads and Writes

The project implements **CQRS (Command Query Responsibility Separation)**, where state-changing operations (commands) are separated from data retrieval operations (queries).  
This results in a cleaner architecture and better scalability.

### Why CQRS was chosen:

- Commands modify state and **do not depend on read models**.
- Queries are optimized for fast data access and do not affect business logic.
- It simplifies future development — the read model can be optimized independently (e.g. cached via Redis), while the write model stays clean and consistent.
- Enables independent scaling — **write service ≠ read service**, with the option to move them to separate nodes in the future.

CQRS is especially useful in a review/rating subsystem, where **read operations occur far more frequently than writes**, and low-latency access is crucial.

---

## 2. Core functionality was developed using **TDD (Test-Driven Development)**

For core modules the development followed **a test-first approach**.  
This allowed us to:

- formalize requirements before writing implementation,
- reduce hidden defects,
- safely refactor logic without regression,
- make tests a living specification of expected behavior.

Tests document how the system should behave, increasing predictability and maintainability.

---

## 3. CQRS REST API Trade-off

Strict CQRS principles state that commands **should not return data**.  
However, in REST APIs it’s common and convenient to return an identifier of a newly created entity.

### Possible approaches:

1. **Client generates UUID and sends it within the command**  
   Command returns nothing.
  + ideal for CQRS
  + scalable architecture  
    − requires clients to generate UUIDs

2. **Command returns ID after creation**  
   A practical compromise for REST.
  + improves DX and API usability  
    − slightly violates pure CQRS rules

---

## 4. Why the average rating is stored **both in DB and Redis**

The caching strategy used is **write-through cache**, and storing data twice is an intentional decision.

### Redis is used for reads:

- near-instant lookup,
- optimized for frequently accessed read-model,
- enables building top lists without heavy DB queries,
- avoids DB I/O and locking under load.

### Database is the system of record:

- persistent storage,
- supports analytics and filtering,
- does not lose data on cache flush or failover.

Dual-storage improves **performance, reliability, and scalability**.

---

## 5. Planned Improvements

The project currently functions as a working prototype.  
Below is a roadmap of enhancements for future development.

### A) Reliability and correctness

- Proper HTTP error codes (currently most errors fall into 500)
- Validation for incoming DTOs/commands
- Improved logging:
  - switch to **Monolog with structured context**
  - JSON logs for ELK/Grafana Loki compatibility
  - correlation ID per request for traceability

### B) Code quality & maintainability

- Automatic OpenAPI/Swagger generation
- Increase unit test coverage (target 70%+)
- Apply static analysis & linters:
  - PHP: **phpstan/psalm + php-cs-fixer/phpcs**
  - Node: **eslint** (or **biome** as a modern alternative)
  - CI enforced pre-commit hooks (**husky + lint-staged**)

### C) DevOps & Infrastructure

- Deploy project into **Kubernetes cluster**
  - separate scaling for read and write components
- Observability setup:
  - Prometheus/Grafana metrics and dashboards
  - alerting on latency/availability issues
- Optional split of read model as a standalone microservice

### D) Introduce Custom Exceptions

- Implement project-specific exception classes to clearly distinguish domain, application, and infrastructure errors.
  This will improve debugging, allow more accurate HTTP status mapping, and make error handling more explicit and predictable.







