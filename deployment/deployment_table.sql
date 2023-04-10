CREATE TABLE deployment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_machine VARCHAR(255),
  to_machine VARCHAR(255),
  feature VARCHAR(255),
  file_path VARCHAR(255),
  version DOUBLE,
  dateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
