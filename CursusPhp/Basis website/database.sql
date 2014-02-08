DROP TABLE IF EXISTS appointmentcourses;
DROP TABLE IF EXISTS appointmentlecturers;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS appointments;
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

    PRIMARY KEY(appointmentid)

) ENGINE=InnoDB;

CREATE TABLE courses (

    courseid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    coursename VARCHAR(64) NOT NULL,

    PRIMARY KEY(courseid)

) ENGINE=InnoDB;

CREATE TABLE appointmentlecturers (
    
    appointmentlecturerid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    appointmentid INTEGER UNSIGNED NOT NULL,
    lecturerid INTEGER UNSIGNED NOT NULL,
    start_timestamp DATETIME NOT NULL,
    end_timestamp DATETIME NOT NULL,
    interval_timestamp DATETIME NOT NULL,

    PRIMARY KEY(appointmentlecturerid),
    FOREIGN KEY(appointmentid) REFERENCES appointments(appointmentid) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(lecturerid) REFERENCES users(userid) ON UPDATE CASCADE ON DELETE CASCADE

) ENGINE=InnoDB;

CREATE TABLE appointmentcourses (
    
    appointmentcourseid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    appointmentid INTEGER UNSIGNED NOT NULL,
    courseid INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY(appointmentcourseid),
    FOREIGN KEY(appointmentid) REFERENCES appointments(appointmentid) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(courseid) REFERENCES courses(courseid) ON UPDATE CASCADE ON DELETE CASCADE

) ENGINE=InnoDB;