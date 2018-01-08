use CST8257;


#User Table Data
INSERT INTO Users (UserId, Name, Phone, Password) VALUES 
('0001', 'Jon Snow', '6131234567', 'password1'),
('0002', 'Barry Allen', '6131234567', 'password1'),
('0003', 'Clark Kent', '6131234567', 'password1'),
('0004', 'Reverse Flash', '6131234567', 'password1'),
('0005', 'For Darksied', '6131234567', 'password1');


#Accessibility Data
INSERT INTO Accessibility (Accessibility_Code, Description) VALUES
('private', 'Accessible only by the owner'),
('shared', 'Accessible by the owner and friends');


# Album Data
INSERT INTO Album (Album_Id, Title, Description, Date_Updated, Owner_Id, Accessibility_Code) VALUES 
('0001', 'Friends', 'Toronto tour', '2018-01-12', '0001', 'shared'),
('0002', 'Personal Pictures', 'Jon\'s personal pictures', '2017-01-15', '0001', 'private'),
('0003', 'Family trip', 'Family trip to bahamas', '2015-12-05', '0001', 'shared'),
('0004', 'School tour', 'US School tour', '2014-03-16', '0002', 'shared'),
('0005', 'Personal Pictures', 'Barry\'s personal pictures', '2018-07-14', '0002', 'private'),
('0006', 'Family trip', 'Family trip to Halifax', '2010-11-13', '0002', 'shared'),
('0007', 'College tour', 'Europe College tour', '2015-10-10', '0003', 'shared'),
('0008', 'Personal Pictures', 'Clark\'s personal pictures', '2017-01-12', '0003', 'private'),
('0009', 'Family trip', 'Family trip to China', '2013-11-12', '0003', 'shared');

# FriendShip Status
INSERT INTO FriendshipStatus (Status_Code, Description) VALUES
('accepted', 'The request to become a friend has been accepted'),
('request', 'A request has been sent to become a friend');



# Friends
INSERT INTO Friendship (Friend_RequesterId, Friend_RequesteeId, Status) VALUES 
('0001', '0002', 'accepted'),
('0001', '0003', 'accepted'),
('0004', '0001', 'request'),
('0005', '0001', 'request'),
('0005', '0004', 'accepted');

