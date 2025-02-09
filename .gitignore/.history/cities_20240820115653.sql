CREATE TABLE ville_france (
    id_dpt INT AUTO_INCREMENT PRIMARY KEY,
    insee_code VARCHAR(5) NOT NULL,
    city_code VARCHAR(3) NOT NULL,
    zip_code VARCHAR(5) NOT NULL,
    label VARCHAR(100) NOT NULL,
    latitude DECIMAL(9,6) DEFAULT NULL,
    longitude DECIMAL(9,6) DEFAULT NULL,
    department_name VARCHAR(100) NOT NULL,
    department_number VARCHAR(3) NOT NULL,
    region_name VARCHAR(100) DEFAULT NULL,
    INDEX (insee_code),
    INDEX (city_code),
    INDEX (zip_code),
    INDEX (department_number)
);