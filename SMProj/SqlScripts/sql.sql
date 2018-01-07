## Connect to your sqlserver using your sqlclient
## Create Database by the name of "CST8257"
## Run the script to create all the tables

DROP TABLE IF EXISTS CST8257.Comments;
DROP TABLE IF EXISTS CST8257.Friendship;
DROP TABLE IF EXISTS CST8257.Picture;
DROP TABLE IF EXISTS CST8257.Album;
DROP TABLE IF EXISTS CST8257.Users;
DROP TABLE IF EXISTS CST8257.Accessibility;
DROP TABLE IF EXISTS CST8257.FriendshipStatus;


CREATE TABLE CST8257.Users (
   	UserId varchar(16) NOT NULL PRIMARY KEY,
   	Name varchar(256) NOT NULL,
   	Phone varchar(16),
   	Password varchar(256)
);

CREATE TABLE CST8257.Accessibility (
	Accessibility_Code varchar(16) NOT NULL PRIMARY KEY,
  	Description varchar(127) NOT NULL
);

CREATE TABLE CST8257.Album (
	Album_Id int(11) PRIMARY KEY AUTO_INCREMENT,
	Title varchar(256) NOT NULL,
	Description varchar(3000), 
	Date_Updated Date NOT NULL,
	Owner_Id varchar(16) NOT NULL,
	Accessibility_Code varchar(16) NOT NULL,
	FOREIGN KEY (Owner_Id) REFERENCES Users (UserId),
	FOREIGN KEY (Accessibility_Code) REFERENCES Accessibility (Accessibility_Code)
);

CREATE TABLE CST8257.Picture (
	Picture_Id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Album_Id int(11) NOT NULL,
	FileName varchar(255) NOT NULL,
	Title varchar(256) NOT NULL,
	Description varchar(3000),
	Date_Added date NOT NULL,
	FOREIGN KEY (Album_Id) REFERENCES Album (Album_Id)
);

CREATE TABLE CST8257.Comments (
	Comment_Id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Author_Id varchar(16) NOT NULL,
	Picture_Id int(11) NOT NULL,
	Comment_Text varchar(3000) NOT NULL,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (Author_Id) REFERENCES Users (UserId),
	FOREIGN KEY (Picture_Id) REFERENCES Picture (Picture_Id)
);

CREATE TABLE CST8257.FriendshipStatus (
	Status_Code varchar(16) NOT NULL PRIMARY KEY,
	Description varchar(128) NOT NULL
);

CREATE TABLE CST8257.Friendship (
	Friend_RequesterId varchar(16) NOT NULL,
	Friend_RequesteeId varchar(16) NOT NULL,
	Status varchar(16) NOT NULL,
	FOREIGN KEY (Friend_RequesterId) REFERENCES Users (UserId),
	FOREIGN KEY (Friend_RequesteeId) REFERENCES Users (UserId),
	FOREIGN KEY (Status) REFERENCES FriendshipStatus (Status_Code)
);
