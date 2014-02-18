DROP TABLE IF EXISTS appointmentsubscribers;
DROP TABLE IF EXISTS appointmentslots;
DROP TABLE IF EXISTS appointments;
DROP VIEW IF EXISTS students;
DROP VIEW IF EXISTS administrators;
DROP VIEW IF EXISTS studentadvisors;
DROP VIEW IF EXISTS lecturers;
DROP TABLE IF EXISTS users;

CREATE TABLE users (

    userid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) NOT NULL,
    firstname VARCHAR(32) NOT NULL,
    lastname VARCHAR(32) NOT NULL,
    password VARCHAR(129) NOT NULL,
    email VARCHAR(128) NOT NULL,
    accesslevel TINYINT UNSIGNED NOT NULL DEFAULT 0,

    PRIMARY KEY(userid)

) ENGINE=InnoDB;

CREATE VIEW students AS
    SELECT *
    FROM users
    WHERE accesslevel = 0;

CREATE VIEW lecturers AS
    SELECT *
    FROM users
    WHERE accesslevel >= 1;

CREATE VIEW studentadvisors AS
    SELECT *
    FROM users
    WHERE accesslevel >= 2;

CREATE VIEW administrators AS 
    SELECT *
    FROM users
    WHERE accesslevel >= 3;

CREATE TABLE appointments (

    appointmentid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    description TEXT NOT NULL,
    start_timestamp DATETIME NOT NULL,
    end_timestamp DATETIME NOT NULL,
    location VARCHAR(32) NOT NULL,
    chronological BOOLEAN NOT NULL,

    PRIMARY KEY(appointmentid)

) ENGINE=InnoDB;

CREATE TABLE appointmentslots (
    
    appointmentslotid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    appointmentid INTEGER UNSIGNED NOT NULL,
    lecturerid INTEGER UNSIGNED NOT NULL,
    start_timestamp DATETIME NOT NULL,
    end_timestamp DATETIME NOT NULL,

    PRIMARY KEY(appointmentslotid),
    FOREIGN KEY(appointmentid) REFERENCES appointments(appointmentid) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(lecturerid) REFERENCES users(userid) ON UPDATE CASCADE ON DELETE CASCADE

) ENGINE=InnoDB;

CREATE TABLE appointmentsubscribers (

    appointmentsubscriberid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    appointmentslotid INTEGER UNSIGNED NOT NULL,
    userid INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY(appointmentsubscriberid),
    FOREIGN KEY(appointmentslotid) REFERENCES appointmentslots(appointmentslotid) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(userid) REFERENCES users(userid) ON UPDATE CASCADE ON DELETE CASCADE

) ENGINE=InnoDB;


INSERT INTO `users` (`userid`, `username`, `firstname`, `lastname`, `password`, `email`, `accesslevel`) VALUES
(1, 'r0331013', 'Sander', 'Decoster', '2F9959B230A44678DD2DC29F037BA1159F233AA9AB183CE3A0678EAAE002E5AA6F27F47144A1A4365116D3DB1B58EC47896623B92D85CB2F191705DAF11858B8', 'sander.decoster@student.khleuven.be', 0),
(2, 'r0426942', 'David', 'Andrianne', '2F9959B230A44678DD2DC29F037BA1159F233AA9AB183CE3A0678EAAE002E5AA6F27F47144A1A4365116D3DB1B58EC47896623B92D85CB2F191705DAF11858B8', 'david.andrianne@student.khleuven.be', 0),
(3, 'elste', 'Elke', 'Steegmans', '2F9959B230A44678DD2DC29F037BA1159F233AA9AB183CE3A0678EAAE002E5AA6F27F47144A1A4365116D3DB1B58EC47896623B92D85CB2F191705DAF11858B8', 'elke.steegmans@khleuven.be', 1),
(4, 'jahee', 'Jan', 'Van Hee', '2F9959B230A44678DD2DC29F037BA1159F233AA9AB183CE3A0678EAAE002E5AA6F27F47144A1A4365116D3DB1B58EC47896623B92D85CB2F191705DAF11858B8', 'jan.van.hee@khleuven.be', 2),
(5, 'pigee', 'Pieter', 'Geens', '2F9959B230A44678DD2DC29F037BA1159F233AA9AB183CE3A0678EAAE002E5AA6F27F47144A1A4365116D3DB1B58EC47896623B92D85CB2F191705DAF11858B8', 'pieter.geens@khleuven.be', 3);


INSERT INTO `appointments` (`appointmentid`, `description`, `start_timestamp`, `end_timestamp`, `location`, `chronological`) VALUES
(1, 'Exameninzage studenten Dynweb 2TI3', '2014-05-30 08:00:00', '2014-05-30 18:00:00', 'Lokaal 320', 1),
(2, 'Bespreking eindwerk studenten 3TI3', '2014-06-11 10:00:00', '2014-06-11 19:00:00', 'Lokaal 14', 0),
(3, 'Bespreking opdrachten Web Design studenten 1TI5', '2014-04-30 08:00:00', '2014-04-30 16:00:00', 'Lokaal 307', 0);

INSERT INTO `appointmentslots` (`appointmentslotid`, `appointmentid`, `lecturerid`, `start_timestamp`, `end_timestamp`) VALUES
(1, 2, 3, '2014-06-11 10:00:00', '2014-06-11 11:00:00'),
(2, 2, 3, '2014-06-11 11:00:00', '2014-06-11 12:00:00'),
(3, 2, 3, '2014-06-11 12:00:00', '2014-06-11 13:00:00'),
(4, 2, 3, '2014-06-11 13:00:00', '2014-06-11 14:00:00'),
(5, 2, 5, '2014-06-11 14:00:00', '2014-06-11 14:45:00'),
(6, 2, 5, '2014-06-11 14:45:00', '2014-06-11 15:30:00'),
(7, 2, 5, '2014-06-11 15:30:00', '2014-06-11 16:15:00'),
(8, 1, 3, '2014-05-30 12:00:00', '2014-05-30 12:15:00'),
(9, 1, 3, '2014-05-30 12:15:00', '2014-05-30 12:30:00'),
(10, 1, 3, '2014-05-30 12:30:00', '2014-05-30 12:45:00'),
(11, 1, 3, '2014-05-30 12:45:00', '2014-05-30 13:00:00'),
(12, 1, 3, '2014-05-30 13:00:00', '2014-05-30 13:15:00'),
(13, 1, 3, '2014-05-30 13:15:00', '2014-05-30 13:30:00'),
(14, 1, 3, '2014-05-30 13:30:00', '2014-05-30 13:45:00'),
(15, 1, 3, '2014-05-30 13:45:00', '2014-05-30 14:00:00'),
(16, 1, 3, '2014-05-30 14:00:00', '2014-05-30 14:15:00'),
(17, 1, 3, '2014-05-30 14:15:00', '2014-05-30 14:30:00'),
(18, 1, 3, '2014-05-30 14:30:00', '2014-05-30 14:45:00'),
(19, 1, 3, '2014-05-30 14:45:00', '2014-05-30 15:00:00'),
(20, 1, 3, '2014-05-30 15:00:00', '2014-05-30 15:15:00'),
(21, 1, 3, '2014-05-30 15:15:00', '2014-05-30 15:30:00'),
(22, 1, 3, '2014-05-30 15:30:00', '2014-05-30 15:45:00'),
(23, 1, 3, '2014-05-30 15:45:00', '2014-05-30 16:00:00'),
(24, 3, 4, '2014-04-30 10:00:00', '2014-04-30 10:10:00'),
(25, 3, 4, '2014-04-30 10:10:00', '2014-04-30 10:20:00'),
(26, 3, 4, '2014-04-30 10:20:00', '2014-04-30 10:30:00'),
(27, 3, 4, '2014-04-30 10:30:00', '2014-04-30 10:40:00'),
(28, 3, 4, '2014-04-30 10:40:00', '2014-04-30 10:50:00'),
(29, 3, 4, '2014-04-30 10:50:00', '2014-04-30 11:00:00'),
(30, 3, 4, '2014-04-30 11:00:00', '2014-04-30 11:10:00'),
(31, 3, 4, '2014-04-30 11:10:00', '2014-04-30 11:20:00'),
(32, 3, 4, '2014-04-30 11:20:00', '2014-04-30 11:30:00'),
(33, 3, 4, '2014-04-30 11:30:00', '2014-04-30 11:40:00'),
(34, 3, 4, '2014-04-30 11:40:00', '2014-04-30 11:50:00'),
(35, 3, 4, '2014-04-30 11:50:00', '2014-04-30 12:00:00'),
(36, 3, 4, '2014-04-30 12:00:00', '2014-04-30 12:10:00'),
(37, 3, 4, '2014-04-30 12:10:00', '2014-04-30 12:20:00'),
(38, 3, 4, '2014-04-30 12:20:00', '2014-04-30 12:30:00'),
(39, 3, 4, '2014-04-30 12:30:00', '2014-04-30 12:40:00'),
(40, 3, 4, '2014-04-30 12:40:00', '2014-04-30 12:50:00'),
(41, 3, 4, '2014-04-30 12:50:00', '2014-04-30 13:00:00'),
(42, 3, 4, '2014-04-30 13:00:00', '2014-04-30 13:10:00'),
(43, 3, 4, '2014-04-30 13:10:00', '2014-04-30 13:20:00'),
(44, 3, 4, '2014-04-30 13:20:00', '2014-04-30 13:30:00'),
(45, 3, 4, '2014-04-30 13:30:00', '2014-04-30 13:40:00'),
(46, 3, 4, '2014-04-30 13:40:00', '2014-04-30 13:50:00'),
(47, 3, 4, '2014-04-30 13:50:00', '2014-04-30 14:00:00');

INSERT INTO `appointmentsubscribers` (`appointmentsubscriberid`, `appointmentslotid`, `userid`) VALUES
(1, 2, 3),
(2, 6, 5),
(3, 3, 1),
(4, 8, 1),
(5, 24, 1),
(6, 1, 2),
(7, 9, 2),
(8, 25, 2);

