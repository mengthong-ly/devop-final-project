## 📦 Laravel Microservices Architecture

This repository contains a **microservices-based system** built using:

* **Laravel 12** (three separate projects)
* **Docker** & **Docker Compose**
* **PostgreSQL Databases**
* **GitHub Actions CI/CD**
* **Docker Hub** Image Registry
* **AWS EC2** Deployment

Each service is fully isolated and independently deployable.

---

### 📁 Project Structure
    microservices/ 
        │ 
        ├── users-service/ # Laravel project for User Management 
        ├── tasks-service/ # Laravel project for Task Management 
        ├── assignments-service/ # Laravel project for Assignments 
        │ 
        ├── docker-compose.yml # Runs all microservices + databases in production 
        └── README.md

    Each folder is a full standalone Laravel app with its own: **migrations**, **controllers**, **models**, **routes**, **env files**, and **Dockerfile**.

---

### 🚀 Features

* **✔ Microservices Architecture:** Each service has its own logic, database, Dockerfile, container, and CI pipeline.
* **✔ Independent CI/CD:** Each service pushes its Docker image to **Docker Hub** whenever files inside that folder change.
* **✔ Independent Databases:** Each service has its own **PostgreSQL** database container.
* **✔ Fully Dockerized:** No local PHP/Composer/NPM required.
* **✔ EC2 Hosting With Docker Compose:** Production deployment uses pre-built Docker images (**no build on server**).

---

### 🧱 Technology Stack

| Component | Technology |
| :--- | :--- |
| **Backend** | Laravel 12 |
| **Databases** | PostgreSQL 15 |
| **Deployment** | Docker + Docker Compose |
| **CI/CD** | GitHub Actions |
| **Container Registry** | Docker Hub |
| **Hosting** | AWS EC2 (Ubuntu 22.04) |

---

### 📦 Build Instructions (Local Development)

#### 1️⃣ Clone the repo

    ```bash
    git clone [https://github.com/](https://github.com/)<your-username>/<repo>.git
    cd microservices

#### 2️⃣ Build and Run All Services Locally
    docker compose up --build

#### 3️⃣ Enter a service container (example: tasks-service)
    docker exec -it tasks-service bash
Repeat for: users-service, tasks-service, and assignments-service.

#### 4️⃣ Run migrations inside each container
    php artisan migrate
Repeat for: users-service, tasks-service, and assignments-service.

## 🛠 Production Deployment on AWS EC2
#### 1️⃣ Create an EC2 instanceOS: 
    Ubuntu 22.04Open ports: 22, 80, 8001, 8002, 8003
#### 2️⃣ SSH into the server

    ssh -i "~/Downloads/aws-key.pem" ubuntu@<EC2_IP>
#### 3️⃣ Install Docker & Docker Compose
    curl -fsSL [https://get.docker.com](https://get.docker.com) -o install-docker.sh
    sudo sh install-docker.sh

    sudo usermod -aG docker ubuntu
    Re-login:
    exit
    ssh -i "~/Downloads/aws-key.pem" ubuntu@<EC2_IP>
#### 4️⃣ Upload docker-compose.yml to EC2From your local machine:
    scp -i "~/Downloads/aws-key.pem" docker-compose.yml ubuntu@<EC2_IP>:/home/ubuntu/
#### 5️⃣ Pull latest images from Docker Hub
    docker compose pull
#### 6️⃣ Start all servicesBashdocker compose up -d
#### 7️⃣ Run migrations on production
    docker exec -it users-service php artisan migrate
    docker exec -it tasks-service php artisan migrate
    docker exec -it assignments-service php artisan migrate
## ⚙️ CI/CD WorkflowEach microservice has its own GitHub Actions workflow:
- Example for tasks-service: .github/workflows/tasks-service.yml 
- Workflow triggers whenever files in tasks-service/** change.

Steps included:
1. Checkout code
2. Login to Docker Hub
3. Build Docker image
4. Push image to Docker Hub
5. Team members only commit normally — the CI/CD handles all builds.
## 📄 Environment Variables
Each service must have:

    APP_KEY=generated_via_docker
    APP_ENV=production
    APP_DEBUG=false

    DB_CONNECTION=pgsql
    DB_HOST=<service-db-name>
    DB_PORT=5432
    DB_DATABASE=<your-db>
    DB_USERNAME=postgres
    DB_PASSWORD=postgres

To generate key inside container:

    docker exec -it users-service php artisan key:generate
## 🎨 Building Frontend Assets (if applicable)For services using Tailwind/Vite:B
    npm install
    npm run build
Note: These built assets must be committed so Docker can serve them.

---
## 📚 API Documentation

| Service | Endpoint | Description |
| :--- | :--- | :--- |
| Users Service | /api/users | CRUD operations |
| Tasks Service | /api/tasks | CRUD operations |
| Assignments Service | /api/assignments | Assign task → user |

---

### 👥 Team Workflow Guidelines

Developers should:

* **✔ Work** inside each service folder independently.
* **✔ Commit** and push normally.
* **✔ Allow** GitHub Actions to build and deploy Docker images.
* **✔ Avoid** SSH-ing into production unless necessary.

---

### 📌 Notes

* `.env` files are **NOT committed** — create them manually in each container.
* Vite/Tailwind must be built **before pushing** to production.
* Docker images on EC2 are always **pulled from Docker Hub**.

---

### 🏁 Final Result

After completing all steps:

* All 3 microservices run on EC2
* API endpoints work
* UI loads with proper assets
* Databases persist
* CI/CD auto-builds new images