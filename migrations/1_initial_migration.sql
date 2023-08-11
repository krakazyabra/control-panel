CREATE DATABASE vps_sale;
CREATE USER vps_user WITH PASSWORD 'vps_password';

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vps_orders (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    vps_config JSON NOT NULL,
    proxmox_node VARCHAR(255),
    vps_id VARCHAR(255),
    console_url VARCHAR(255),
    login VARCHAR(255),
    password VARCHAR(255),
    date_ordered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

GRANT ALL PRIVILEGES ON DATABASE vps_sale TO vps_user;
UPDATE users SET username = LOWER(username);
