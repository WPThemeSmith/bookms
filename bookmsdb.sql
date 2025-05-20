CREATE TABLE books (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  author varchar(255) NOT NULL,
  isbn varchar(255) NOT NULL,
  price decimal(10,2) NOT NULL,
  publisher varchar(255) NOT NULL,
  
  description text NOT NULL,
  cover_image varchar(255) NOT NULL,
  PRIMARY KEY (id)
);
