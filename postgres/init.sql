CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50),
    password TEXT
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100)
);

CREATE TABLE articles (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
    slug VARCHAR(255),
    content TEXT,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);