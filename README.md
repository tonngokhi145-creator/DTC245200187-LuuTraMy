# RECIPE VIET - WEBSITE CONG THUC NAU AN

## Thong tin sinh vien
- Ma sinh vien: DTC245200187
- Ho ten: Luu Tra My
- De tai: Website chia se cong thuc nau an

## Gioi thieu
Website Recipe Viet cho phep xem, tim kiem va
quan ly cong thuc nau an theo danh muc.

## Commit 1 - Website va Database

Cong nghe:
- WordPress + PHP
- MySQL 8.4
- phpMyAdmin
- Nginx Reverse Proxy
- Docker Compose

Chuc nang:
- Hien thi danh sach mon an
- Xem chi tiet nguyen lieu va cach che bien
- Tim kiem cong thuc
- Quan ly danh muc mon an
- Quan tri noi dung bang WordPress

Khoi chay:
1. Cai Docker Desktop va Docker Compose.
2. Sao chep .env.example thanh .env.
3. Thiet lap mat khau manh trong .env.
4. Chay docker compose up -d.
5. Truy cap website va cai dat WordPress lan dau.

Dia chi:
- Website: http://localhost:8088
- phpMyAdmin: http://localhost:8089

Database: recipe_db

Du lieu duoc luu trong Docker volumes.
Khong dua file .env len GitHub.

## Commit 2 - Prometheus va Grafana

### 1. Muc tieu
Giam sat tai nguyen may chu, Docker containers,
MySQL va Nginx bang Prometheus va Grafana.

He thong duoc trien khai dua tren QT7.pdf,
Chuong 7, muc 7.3.

### 2. Thanh phan Monitoring

- Prometheus: Thu thap va luu metrics.
- Grafana: Hien thi Dashboard.
- Node Exporter: Giam sat CPU, RAM, Disk.
- cAdvisor: Giam sat Docker containers.
- MySQL Exporter: Giam sat MySQL.
- Nginx Exporter: Giam sat Nginx.

### 3. Cau truc cau hinh

- compose.monitoring.yaml
- prometheus/prometheus.yml
- grafana/provisioning/datasources/prometheus.yml
- mysql/init-exporter.sh

### 4. Khoi dong Monitoring

Kiem tra cau hinh:

docker compose -f compose.yaml -f compose.monitoring.yaml config --quiet

Khoi dong:

docker compose -f compose.yaml -f compose.monitoring.yaml up -d

Kiem tra:

docker compose -f compose.yaml -f compose.monitoring.yaml ps

### 5. Dia chi truy cap

Prometheus:
http://localhost:19090

Prometheus Targets:
http://localhost:19090/targets

Grafana:
http://localhost:13000

Grafana Data Source:
http://prometheus:9090

Tai khoan Grafana:
- Username: admin
- Password: GRAFANA_ADMIN_PASSWORD trong .env

### 6. Docker Networks

app-network:
- WordPress
- MySQL
- Nginx va cac dich vu ung dung

monitoring:
- Prometheus
- Grafana
- Node Exporter
- cAdvisor
- Cac Exporter

MySQL Exporter ket noi ca app-network
va monitoring de thu thap metrics.

### 7. Prometheus Metrics

Truy van kiem tra:

up
mysql_up
nginx_up

Ket qua kiem tra:
- Prometheus Target: UP
- Node Exporter Target: UP
- cAdvisor Target: UP
- MySQL Exporter: mysql_up = 1
- Nginx Exporter: nginx_up = 1

### 8. Grafana Dashboards

Dashboard da import:

- Node Exporter Full - ID 1860
- MySQL Overview - ID 7362
- cAdvisor Exporter - ID 14282

Node Exporter va MySQL Overview da co du lieu.

Dashboard cAdvisor da import nhung cac panel
CPU, Memory hien dang No data.
Can kiem tra va khac phuc truoc khi ket luan
giam sat tai nguyen container hoan thanh.

### 9. Bao mat

- Su dung mat khau trong file .env
- Khong commit file .env
- MySQL Exporter su dung tai khoan rieng
- Tach Docker networks
- Grafana va Prometheus chi expose tren localhost

### 10. Tai lieu tham khao

QT7.pdf - Chuong 7:
Giam sat he thong may chu.

Phan thuc hanh:
- 7.3.2 Docker Compose
- 7.3.3 Docker Network
- 7.3.4 Grafana Dashboard

## Docker Container Monitoring - Telegraf

He thong su dung Docker, Telegraf, Prometheus va Grafana
de giam sat tai nguyen cua cac container.

### 1. Kien truc Monitoring

- Docker Socket Proxy: cung cap Docker API cho Telegraf.
- Telegraf: thu thap CPU, RAM va Network container.
- Prometheus: luu tru va truy van metrics.
- Grafana: hien thi Dashboard Monitoring.

### 2. Khoi dong he thong

docker compose -f compose.yaml -f compose.monitoring.yaml up -d

Kiem tra container:

docker compose -f compose.yaml -f compose.monitoring.yaml ps

### 3. Kiem tra metrics

Truy cap Grafana: http://localhost:13000

Truy cap Prometheus: http://localhost:19090

Truy van PromQL:

up{job="docker-telegraf"}

### 4. Dashboard Recipe Viet

Dashboard: Recipe Viet - Docker Container Monitoring

Dashboard gom 3 bieu do:

- Docker CPU Usage (%)
- Docker Memory Usage (MiB)
- Docker Network Traffic (Bytes/sec)

Du lieu duoc nhom theo ten Docker container.

### 5. Dashboard JSON

File JSON duoc xuat tu Grafana:

grafana/dashboards/recipe-docker-monitoring.json

File duoc luu trong repository de phuc vu
minh chung va tai su dung Dashboard.
Viec tu dong provisioning can cau hinh them
theo dinh dang JSON Grafana tuong thich.

---

## Commit 3 - Centralized Logging and Alerting

### 1. Logging Stack

He thong su dung:

- Loki: Luu tru va truy van logs.
- Promtail: Thu thap Docker container logs.
- Grafana: Hien thi logs va metrics.
- Alertmanager: Tiep nhan va quan ly canh bao.

Cau hinh:

- compose.logging.yaml
- loki/loki.yml
- promtail/promtail.yml
- alertmanager/alertmanager.yml
- grafana/provisioning/datasources/loki.yml

### 2. Khoi dong Logging

```bash
docker compose -f compose.yaml \
  -f compose.monitoring.yaml \
  -f compose.logging.yaml up -d
```

### 3. Truy van Logs

Mo Grafana tai:

http://localhost:13000

Chon Explore, Data source Loki.

WordPress logs:

```logql
{service="wordpress"}
```

Nginx logs:

```logql
{service="nginx"}
```

### 4. Dashboard Logs & Metrics

Dashboard: Recipe Viet - Logs & Metrics

Bao gom 3 panel:

- Nginx Requests - Last 5 Minutes
- Docker CPU Usage - Recipe Viet
- WordPress Application Logs

File Dashboard JSON:

grafana/dashboards/recipe-viet-logs-metrics.json

### 5. Prometheus Alert Rules

File:

prometheus/rules/alerts.yml

Gom 5 canh bao:

1. WordPressHighCPU
2. WordPressHighMemory
3. MySQLTooManyConnections
4. MySQLErrorRateHigh
5. HighDiskUsage

### 6. Kiem thu Alertmanager

Da kiem thu thanh cong:

- Prometheus tai duoc 5 Alert Rules.
- Rule Health hien thi OK.
- Prometheus nhan dien Alertmanager.
- RecipeVietTestAlert chuyen sang FIRING.
- Alertmanager nhan duoc canh bao.
- Da xoa rule thu nghiem sau khi test.

Luu y: Viec gui email can canh hinh receiver rieng.

### 7. Dia chi truy cap

- Prometheus: http://localhost:19090
- Grafana: http://localhost:13000
- Alertmanager: http://localhost:19093
