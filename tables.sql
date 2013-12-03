CREATE TABLE Users (
 
 email VARCHAR(80) NOT NULL,
 username VARCHAR(50) PRIMARY KEY,
 password VARCHAR(255) NOT NULL,
 isAdmin TINYINT(1) NOT NULL
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