CREATE TABLE IF NOT EXISTS accounts (
	id int(11) NOT NULL AUTO_INCREMENT,
  	username varchar(50) NOT NULL,
  	password varchar(255) NOT NULL,
  	email varchar(100) NOT NULL,
	profilePicture varchar(255) NOT NULL DEFAULT 'testing.jpg',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS studentDetails (
	id int NOT NULL AUTO_INCREMENT,
	Studentid int NOT NULL,
	name varchar(255) NOT NULL,
	description varchar(255) NOT NULL,
	age int NOT NULL,
	math bool NOT NULL,
	english bool NOT NULL,
	science bool NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id) REFERENCES accounts(id)
)

--@BLOCK
INSERT INTO accounts (id, username, password, email) VALUES (1, 'test', 'test', 'test@test.com');
INSERT INTO studentDetails (id, Studentid, name, description, age, math, english, science) VALUES (1, 1, 'test', 'test', 10, 1, 1, 1);

--@BLOCK
SELECT * FROM accounts

--@BLOCK
SELECT * FROM studentDetails


--@BLOCK
DROP TABLE IF EXISTS studentDetails;
DROP TABLE IF EXISTS accounts;
