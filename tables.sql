CREATE TABLE Users (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(80) NOT NULL,
 username VARCHAR(50),
 password VARCHAR(255) NOT NULL,
 isAdmin TINYINT(1) NOT NULL,
 auth TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE Airport
(
	code CHAR(20), 
	city VARCHAR(255),
	state VARCHAR(30),
	name VARCHAR(255),
	PRIMARY KEY(code)
);

CREATE TABLE Airplane
(
	ID CHAR(20), 
	type VARCHAR(30),
	numSeats INT NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE Trip
(
	tripNum VARCHAR(255), 
	airline VARCHAR(255) NOT NULL,
	price REAL NOT NULL,
	depCode CHAR(20),
	destCode CHAR(20),
	numLegs INT NOT NULL,
	PRIMARY KEY(tripNum),
	CONSTRAINT c1 FOREIGN KEY (depCode) REFERENCES Airport(code),
	CONSTRAINT c2 FOREIGN KEY (destCode) REFERENCES Airport(code),
	CONSTRAINT checkDepDest CHECK(depCode <> destCode)
);

CREATE TABLE Reservation
(
	reservationNum VARCHAR(255), 
	email VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,
	address VARCHAR(255) NOT NULL,
	phoneNum INT,
	reserveDate VARCHAR(30) NOT NULL,
	PRIMARY KEY(reservationNum)
);



CREATE TABLE Flight_leg
(
	legNum VARCHAR(255), 
	departureCode CHAR(20),
	destinationCode CHAR(20),
	tripNum VARCHAR(255),
	seatsAvailable INT NOT NULL,
	legDate VARCHAR(20) NOT NULL,
	departTime VARCHAR(20) NOT NULL,
	arriveTime VARCHAR(20) NOT NULL,
	airplaneID CHAR(20),
	PRIMARY KEY(legNum, departureCode, destinationCode, tripNum, airplaneID),
	CONSTRAINT checkAirports CHECK(departureCode <> destinationCode),
	CONSTRAINT c3 FOREIGN KEY (departureCode) REFERENCES Airport(code),
	CONSTRAINT c4 FOREIGN KEY (destinationCode) REFERENCES Airport(code),
	CONSTRAINT c5 FOREIGN KEY (tripNum) REFERENCES Trip(tripNum),
	CONSTRAINT c6 FOREIGN KEY (airplaneID) REFERENCES Airplane(ID),
	CONSTRAINT seatsLeft CHECK (seatsAvailable >= 0)
);

CREATE TABLE Payment
(
	tripNum VARCHAR(255), 
	resNum VARCHAR(255),
	transactionNum CHAR(20),
	paymentDate CHAR(20),
	nameOnAccount VARCHAR(255),
	accountNum VARCHAR(255),
	PRIMARY KEY(tripNum, resNum, transactionNum),
	CONSTRAINT c7 FOREIGN KEY (tripNum) REFERENCES Trip(tripNum),
	CONSTRAINT c8 FOREIGN KEY (resNum) REFERENCES Reservation(reservationNum)
);

--Data
INSERT INTO Airport
VALUES('0000', 'Gainesville', 'Florida', 'Gainesville Regional Airport');
INSERT INTO Airport
VALUES('0001', 'Miami', 'Florida', 'Miami International Airport');
INSERT INTO Airport
VALUES('0002', 'Orlando', 'Florida', 'Orlando International Airport');
INSERT INTO Airport
VALUES('0003', 'Sarasota', 'Florida', 'Sarasota International Airport');
INSERT INTO Airport
VALUES('0004', 'West Palm Beach', 'Florida', 'Palm Beach International Airport');
INSERT INTO Airport
VALUES('0005', 'Ft. Lauderdale', 'Florida', 'Ft. Lauderdale International Airport');
INSERT INTO Airport
VALUES('0006', 'New York City', 'New York', 'MLK International Airport');
INSERT INTO Airport
VALUES('0007', 'New York City', 'New York', 'LaGuardia Airport');

INSERT INTO Airplane
VALUES('1', 'Boeing 747', '400');
INSERT INTO Airplane
VALUES('2', 'Boeing 757', '450');
INSERT INTO Airplane
VALUES('3', 'Boeing 767', '400');
INSERT INTO Airplane
VALUES('4', 'Boeing 777', '380');


INSERT INTO Flight-leg
VALUES('1', '1','2','1', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('2', '2','3','2', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('3', '3','4','3', 400, '11-11-2013','0630','0800','3');
INSERT INTO Flight-leg
VALUES('1', '1','2','4', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('2', '2','3','4', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('1', '1','2','5', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('2', '2','3','5', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('3', '3','4','5', 400, '11-11-2013','1000','1200','1');
INSERT INTO Flight-leg
VALUES('4', '2','1','6', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('5', '3','2','7', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('6', '4','3','8', 400, '11-11-2013','0630','0800','3');
INSERT INTO Flight-leg
VALUES('4', '2','1','9', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('5', '3','2','9', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('4', '2','1','10', 400, '11-11-2013','0400','0600','1');
INSERT INTO Flight-leg
VALUES('5', '3','2','10', 450, '11-11-2013','0630','0800','2');
INSERT INTO Flight-leg
VALUES('6', '4','3','10', 400, '11-11-2013','1000','1200','1');

INSERT INTO Trip
VALUES('1', 'AA',500,'1', '2', 1);
INSERT INTO Trip
VALUES('2', 'Delta',300,'2', '3', 1);
INSERT INTO Trip
VALUES('3', 'Delta',400,'3', '4', 2);
INSERT INTO Trip
VALUES('4', 'AA',800,'1', '3', 2);
INSERT INTO Trip
VALUES('5', 'Canada',1200,'1', '4', 3);
INSERT INTO Trip
VALUES('6', 'AA',500,'2', '1', 1);
INSERT INTO Trip
VALUES('7', 'Delta',300,'3', '2', 1);
INSERT INTO Trip
VALUES('8', 'Delta',400,'4', '3', 2);
INSERT INTO Trip
VALUES('9', 'AA',800,'3', '1', 2);
INSERT INTO Trip
VALUES('10', 'Canada',1200,'4', '1', 3);


--Triggers
CREATE OR REPLACE TRIGGER numSeatsTrigger
	AFTER INSERT ON Payment 
	REFERENCING NEW AS newPayment
	FOR EACH ROW
	
	BEGIN
	UPDATE Flight_leg SET seatsAvailable = seatsAvailable - 1 WHERE :newPayment.tripNum = Flight_leg.tripNum;
	END;
	
	
--This trigger sets the initial number of available seats equal to the capacity of the airplane that is being used for that particular flight leg. 
CREATE OR REPLACE TRIGGER initializeSeatsTrigger
	AFTER INSERT ON Flight_leg
	REFERENCING NEW AS newLeg
	FOR EACH ROW 
	
	BEGIN
	UPDATE Flight_leg SET seatsAvailable = Airplane.numSeats WHERE :newLeg.airplaneID = Airplane.ID;
	END;