DROP DATABASE `cssd`;
CREATE DATABASE `cssd` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;

CREATE TABLE `staff_accounts`(
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(32) NOT NULL,
    `password` varchar(255) NOT NULL
);
INSERT INTO `staff_accounts` VALUES
(NULL,'Dylan','$2y$10$3jEgSHEMQld1nonIzkPZVOqVI1od2mesUG4V5itn3EacbPyWd9/UW'),
(NULL,'Dora','$2y$10$EKMcu1OHsMxZzlpMgt6KIekPiPj5J7ER6XCY9yyIcPioAj/IMgM76'),
(NULL,'Matt','$2y$10$d1IJyUNYIcdFxqkIFZ8KuOTN4z7Da9OFPfMTda7a2dzK4sE1VKfGG'),
(NULL,'Lauren','$2y$10$BftjvBFlRhOZyMfGHCq/4O0WSuzxj78Hr4VHLdoqvnRiouqG3xKue');

CREATE TABLE `client_accounts`(
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(32) NOT NULL,
    `password` varchar(255) NOT NULL
);
INSERT INTO `client_accounts` VALUES 
(NULL,'Dylan','$2y$10$3jEgSHEMQld1nonIzkPZVOqVI1od2mesUG4V5itn3EacbPyWd9/UW'),
(NULL,'Dora','$2y$10$EKMcu1OHsMxZzlpMgt6KIekPiPj5J7ER6XCY9yyIcPioAj/IMgM76'),
(NULL,'Matt','$2y$10$d1IJyUNYIcdFxqkIFZ8KuOTN4z7Da9OFPfMTda7a2dzK4sE1VKfGG'),
(NULL,'Lauren','$2y$10$BftjvBFlRhOZyMfGHCq/4O0WSuzxj78Hr4VHLdoqvnRiouqG3xKue');

CREATE TABLE `client_quotes`(
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `clientID` int NOT NULL,   
    `staffID` int,
    `status` enum('opened','rejected','approved','ammend') DEFAULT 'opened',
    CONSTRAINT FK_ClientID FOREIGN KEY (`clientID`)
    REFERENCES `client_accounts`(`id`),
    CONSTRAINT FK_StaffID FOREIGN KEY (`staffID`)
	REFERENCES `staff_accounts`(`id`)
);
INSERT INTO `client_quotes` VALUES (NULL,1,1,'opened'), (NULL,2,1,'opened'), (NULL,3,1,'opened'), (NULL,4,1,'opened');

CREATE TABLE `products`(
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(32) NOT NULL,
    `description` varchar (255) NOT NULL,
    `lowprice` double NOT NULL,
    `highprice` double NOT NULL
);
INSERT INTO `products` VALUES (NULL,"Smart Meter Mk 1","The first edition of the glorious technology.",12.30,15.99),
(NULL,"Smart Meter Mk 2","The second edition of the glorious technology.",15.99,19.99),
(NULL,"Biomass Boiler - WKD","A biomass boiler which knows how to party.",15000.00,20000.00);

CREATE TABLE `quote_product`(
    `quoteID` int NOT NULL,
    `productID` int NOT NULL,
    `quantity` int NOT NULL DEFAULT 1,
    CONSTRAINT FK_QuoteID FOREIGN KEY (`quoteID`)
    REFERENCES `client_quotes`(`id`),
    CONSTRAINT FK_ItemID FOREIGN KEY (`productID`)
    REFERENCES `products`(`id`),
    CONSTRAINT PK_QuoteProd PRIMARY KEY (`quoteID`,`productID`)
);
INSERT INTO `quote_product` VALUES (1,1,100),(2,1,50),(2,2,25),(2,3,1),(3,3,2),(3,2,50),(4,3,1);


//Run xampp: apache and mysql.
//Copy and paste SQL into: http://localhost/phpmyadmin/server_sql.php
//Run it. 

//This ensures we all have similar databases when testing. Since we are using xampp the database won't get uploaded when we use github/git (good).
//This is just a precautionary measure to ensure testing goes smoothly.