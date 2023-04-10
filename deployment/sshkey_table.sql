CREATE TABLE ssh_table (
  id INT AUTO_INCREMENT PRIMARY KEY,
  machine VARCHAR(255),
  ssh_key VARCHAR(255),
  ip varchar(225),
  deployment_id INT,
  FOREIGN KEY (deployment_id) REFERENCES deployment(id)
);
