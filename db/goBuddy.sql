DROP DATABASE IF EXISTS goBuddy;
CREATE DATABASE IF NOT EXISTS goBuddy;
USE goBuddy;

-- Roles Table
CREATE TABLE IF NOT EXISTS Roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL
);

-- Table for storing user information
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(100) NOT NULL, -- Encrypted password
    Email VARCHAR(100) UNIQUE NOT NULL,
    role_id INT NOT NULL,
    PhoneNumber VARCHAR(20),
    RegistrationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Bio text NOT NULL,
    Stars int not null default 5,
    FOREIGN KEY (role_id) REFERENCES Roles(role_id) ON DELETE CASCADE
);


-- Table for storing trip information
CREATE TABLE Trips (
    TripID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT, -- Foreign key referencing Users table
    Destination VARCHAR(100) NOT NULL,
    Location VARCHAR(100) NOT NULL,
    Date DATE NOT NULL,
    Start TIME NOT NULL,
	End TIME NOT NULL,
    SeatsAvailable INT NOT NULL,
    TimeCreated timestamp DEFAULT CURRENT_TIMESTAMP,
    TripStatus ENUM('Active', 'In Progress', 'Completed','Cancelled') DEFAULT 'Active',
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Table for storing trip requests (when a user requests to join a trip)
CREATE TABLE TripRequests (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    TripID INT, -- Foreign key referencing Trips table
    RequesterUserID INT, -- Foreign key referencing Users table
    Status ENUM('Pending', 'Accepted', 'Rejected','Cancelled') DEFAULT 'Pending',
	TimeCreated timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (TripID) REFERENCES Trips(TripID) ON DELETE CASCADE,
    FOREIGN KEY (RequesterUserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

-- Table for storing user reviews/ratings for trips
CREATE TABLE TripReviews (
    ReviewID INT PRIMARY KEY AUTO_INCREMENT,
    TripID INT, -- Foreign key referencing Trips table
    ReviewerUserID INT, -- Foreign key referencing Users table (the one who leaves the review)
    ReviewedUserID INT, -- Foreign key referencing Users table (the one who is being reviewed)
    Rating INT NOT NULL, -- Rating given by the reviewer (usually on a scale of 1-5)
    ReviewText TEXT,
    ReviewDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (TripID) REFERENCES Trips(TripID),
    FOREIGN KEY (ReviewerUserID) REFERENCES Users(UserID) ON DELETE CASCADE,
    FOREIGN KEY (ReviewedUserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sendersID int NOT NULL,
    receiversID int NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (receiversID) REFERENCES Users(UserID) ON DELETE CASCADE,
	FOREIGN KEY (sendersID) REFERENCES Users(UserID) ON DELETE CASCADE
);


-- Verifiable ID --
CREATE TABLE IF NOT EXISTS VerifiablePins (
    pin_id INT AUTO_INCREMENT PRIMARY KEY,
    pin VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Roles (role_name) VALUES ('Admin'), ('customer');

-- INSERT INTO Users ( Username, Password, Email, role_id, PhoneNumber)
-- VALUES ('Evans Kumi', '$2y$10$QrYHXXWIAhKGhC.0gr1tdeTKlt57tpkKVQ1G4j2rfzg/oJ7JbKiEC', 'kwakukumi14@gmail.com', 1, '+233540722819');
