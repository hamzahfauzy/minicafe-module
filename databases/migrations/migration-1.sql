CREATE TABLE mc_customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(100) DEFAULT NULL,
    address TEXT DEFAULT NULL
);

CREATE TABLE mc_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE mc_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,

    CONSTRAINT fk_mc_categories_section_id FOREIGN KEY (section_id) REFERENCES mc_sections(id) ON DELETE SET NULL
);

CREATE TABLE mc_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    target_id INT DEFAULT NULL,
    category_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,

    CONSTRAINT fk_mc_products_target_id FOREIGN KEY (target_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_mc_products_category_id FOREIGN KEY (category_id) REFERENCES mc_categories(id) ON DELETE SET NULL
);

CREATE TABLE mc_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT DEFAULT NULL,
    total_items INT DEFAULT NULL,
    total_qty INT DEFAULT NULL,
    code VARCHAR(100) NOT NULL,
    table_name VARCHAR(100) DEFAULT NULL,
    floor_name VARCHAR(100) DEFAULT NULL,
    status VARCHAR(100) NOT NULL DEFAULT "NEW", -- NEW, FINISH
    logs JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_mc_orders_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_mc_orders_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,

    CONSTRAINT fk_mc_orders_customer_id FOREIGN KEY (customer_id) REFERENCES mc_customers(id) ON DELETE SET NULL
);

CREATE TABLE mc_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT DEFAULT NULL,
    target_id INT DEFAULT NULL,
    product_id INT DEFAULT NULL,
    qty INT DEFAULT NULL,
    status VARCHAR(100) NOT NULL DEFAULT "NEW", -- NEW, ON PROGRESS, DONE, CLOSE
    logs JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_mc_order_items_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_mc_order_items_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,

    CONSTRAINT fk_mc_order_items_order_id FOREIGN KEY (order_id) REFERENCES mc_orders(id) ON DELETE SET NULL,
    CONSTRAINT fk_mc_order_items_target_id FOREIGN KEY (target_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_mc_order_items_product_id FOREIGN KEY (product_id) REFERENCES mc_products(id) ON DELETE SET NULL
);

INSERT INTO roles (name) VALUES ('Waiter'),('Kitchen');
INSERT INTO role_routes (role_id,route_path,order_number) VALUES ((SELECT id FROM roles WHERE name = 'Waiter'), 'default/*', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), '!default/settings/index', 9),
((SELECT id FROM roles WHERE name = 'Waiter'), 'crud/index?table=mc_order_items', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), 'crud/index?table=mc_orders', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), 'crud/index?table=mc_orders&filter%5Bstatus%5D=NEW', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), 'crud/index?table=mc_orders&filter%5Bstatus%5D=FINISH', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), 'minicafe/orders/create', 10),
((SELECT id FROM roles WHERE name = 'Waiter'), 'minicafe/orders/close-item', 10),

((SELECT id FROM roles WHERE name = 'Kitchen'), 'default/*', 10),
((SELECT id FROM roles WHERE name = 'Kitchen'), '!default/settings/index', 9),
((SELECT id FROM roles WHERE name = 'Kitchen'), 'crud/index?table=mc_order_items', 10);
((SELECT id FROM roles WHERE name = 'Kitchen'), 'minicafe/orders/approve-item', 10);
((SELECT id FROM roles WHERE name = 'Kitchen'), 'minicafe/orders/done-item', 10);