CREATE TABLE Address (
  idAddress INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  district VARCHAR(100) NULL,
  street VARCHAR(255) NULL,
  valuation DECIMAL(10,2) NULL,
  PRIMARY KEY(idAddress)
);

CREATE TABLE breed (
  idBreed INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nameBreed VARCHAR(100) NULL,
  PRIMARY KEY(idBreed)
);

CREATE TABLE client (
  idClient INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  breed_idbreed INTEGER UNSIGNED NOT NULL,
  Address_idAddress INTEGER UNSIGNED NOT NULL,
  owner VARCHAR(250) NOT NULL,
  nameAnimal VARCHAR(255) NOT NULL,
  addressNumber VARCHAR(10) NOT NULL,
  addressComplement VARCHAR(255) NULL,
  phone1 BIGINT NOT NULL,
  phone2 BIGINT NULL,
  email VARCHAR(255) NULL,
  PRIMARY KEY(idClient),
  INDEX client_FKIndex1(Address_idAddress),
  INDEX client_FKIndex2(breed_idbreed)
);

CREATE TABLE diary (
  idDiary INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  client_idClient INTEGER UNSIGNED NOT NULL,
  servic_idServic INTEGER UNSIGNED NOT NULL,
  search TINYINT UNSIGNED NULL,
  price DECIMAL(10,2) NOT NULL,
  deliveryPrice DECIMAL(10,2) NULL,
  totalPrice DECIMAL(10,2) NOT NULL,
  dateHour TIMESTAMP NULL,
  PRIMARY KEY(idDiary),
  INDEX diary_FKIndex1(client_idClient),
  INDEX diary_FKIndex2(servic_idServic)
);

CREATE TABLE servic (
  idServic INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  breed_idBreed INTEGER UNSIGNED NOT NULL,
  nameServic VARCHAR(100) NULL,
  sizeAnimal INTEGER UNSIGNED NULL,
  valuation DECIMAL(10,2) NULL,
  PRIMARY KEY(idServic),
  INDEX servic_FKIndex1(breed_idBreed)
);


