use CST8257;


# Password is "Password1"
#User Table Data
INSERT INTO Users (UserId, UserName, Phone, UserPassword) VALUES 
('0001', 'Jon Snow', '6131234567', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00'),
('0002', 'Barry Allen', '6131234567', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00'),
('0003', 'Clark Kent', '6131234567', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00'),
('0004', 'Reverse Flash', '6131234567', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00'),
('0005', 'For Darksied', '6131234567', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00');


#Accessibility Data
INSERT INTO Accessibility (Accessibility_Code, Description) VALUES
('private', 'Accessible only by the owner'),
('shared', 'Accessible by the owner and friends');


# Album Data
INSERT INTO Album (Title, Description, Date_Updated, Owner_Id, Accessibility_Code) VALUES 
('Friends', 'Toronto tour', '2018-01-12', '0001', 'shared'),
('Personal Pictures', 'Jon\'s personal pictures', '2017-01-15', '0001', 'private'),
('Family trip', 'Family trip to bahamas', '2015-12-05', '0001', 'shared'),
('School tour', 'US School tour', '2014-03-16', '0002', 'shared'),
('Personal Pictures', 'Barry\'s personal pictures', '2018-07-14', '0002', 'private'),
('Family trip', 'Family trip to Halifax', '2010-11-13', '0002', 'shared'),
('College tour', 'Europe College tour', '2015-10-10', '0003', 'shared'),
('Personal Pictures', 'Clark\'s personal pictures', '2017-01-12', '0003', 'private'),
('Family trip', 'Family trip to China', '2013-11-12', '0003', 'shared');


# FriendShip Status
INSERT INTO FriendshipStatus (Status_Code, Description) VALUES
('accepted', 'The request to become a friend has been accepted'),
('request', 'A request has been sent to become a friend');


# Friends
INSERT INTO Friendship (Friend_RequesterId, Friend_RequesteeId, Status_Code) VALUES 
('0001', '0002', 'accepted'),
('0001', '0003', 'accepted'),
('0004', '0001', 'request'),
('0005', '0001', 'request'),
('0005', '0004', 'accepted');


# Picture
INSERT INTO Picture (Album_Id, FileName, Title, Description, Date_Added) VALUES
( 1, 'AB1_Pic1', 'Album1_Picture1', 'Description of Picture 1', '2018-05-11' ),
( 1, 'AB1_Pic2', 'Album1_Picture2', 'Description of Picture 2', '2018-05-12' ),
( 1, 'AB1_Pic3', 'Album1_Picture3', 'Description of Picture 3', '2018-05-13' ),

( 2, 'AB2_Pic1', 'Album2_Picture1', 'Description of Picture 1', '2018-06-11' ),
( 2, 'AB2_Pic2', 'Album2_Picture2', 'Description of Picture 2', '2018-06-12' ),
( 2, 'AB2_Pic3', 'Album2_Picture3', 'Description of Picture 3', '2018-06-13' ),

( 4, 'AB1_Pic1', 'Album4_Picture1', 'Description of Picture 1', '2018-05-11' ),
( 4, 'AB1_Pic2', 'Album4_Picture2', 'Description of Picture 2', '2018-05-12' ),
( 4, 'AB1_Pic3', 'Album4_Picture3', 'Description of Picture 3', '2018-05-13' ),

( 5, 'AB2_Pic1', 'Album5_Picture1', 'Description of Picture 1', '2018-06-11' ),
( 5, 'AB2_Pic2', 'Album5_Picture2', 'Description of Picture 2', '2018-06-12' ),
( 5, 'AB2_Pic3', 'Album5_Picture3', 'Description of Picture 3', '2018-06-13' );


#Comments
INSERT INTO Comments (Author_Id, Picture_Id, Comment_Text, Comment_Date) VALUES 
('0001', 1, '<script>alert(document.cookie);</script>', '2018-06-15'),
('0002', 1, 'Test Comment 2', '2018-06-15'),
('0001', 2, 'Test Comment 3', '2018-06-15'),
('0002', 2, 'Test Comment 4', '2018-06-15');
