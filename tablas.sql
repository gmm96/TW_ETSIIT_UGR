DROP TABLE IF EXISTS `Article`;
DROP TABLE IF EXISTS `Book`;
DROP TABLE IF EXISTS `BookChapter`;
DROP TABLE IF EXISTS `Collaborate`;
DROP TABLE IF EXISTS `Conference`;
DROP TABLE IF EXISTS `Edit`;
DROP TABLE IF EXISTS `Publication-Have`;
DROP TABLE IF EXISTS `Project-Investigate`;
DROP TABLE IF EXISTS `User`;


# Creación tabla User
CREATE TABLE `gmm961617`.`User` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `surname` varchar(200) NOT NULL,
    `category` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `pass` varchar(200) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `url` varchar(300) DEFAULT NULL,
    `department` varchar(100) DEFAULT NULL,
    `center` varchar(100) DEFAULT NULL,
    `university` varchar(100) DEFAULT NULL,
    `address` varchar(200) DEFAULT NULL,
    `photo` varchar(50) NOT NULL,
    `admin` tinyint(1) NOT NULL DEFAULT '0',
    `director` tinyint(1) NOT NULL DEFAULT '0',
    `blocked` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`email`),
    INDEX (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla PROJECTS-INVESTIGATE
CREATE TABLE `gmm961617`.`Project-Investigate` ( 
    `project_id` INT NOT NULL AUTO_INCREMENT, 
    `cod` VARCHAR(50) NOT NULL, 
    `title` VARCHAR(200) NOT NULL, 
    `description` VARCHAR(1000) NULL, 
    `ini-date` DATE NULL, 
    `fin-date` DATE NULL, 
    `associates` VARCHAR(250) NULL, 
    `amount` INT NULL, 
    `url` VARCHAR(300) NULL, 
    `non-group-main-invest` VARCHAR(100) NULL,
    `non-group-collabs` VARCHAR(300) NULL DEFAULT NULL, 
    `main-invest-email` VARCHAR(100) NULL, 
    PRIMARY KEY (`cod`), 
    INDEX (`project_id`), 
    FOREIGN KEY (`main-invest-email`) REFERENCES `User`(`email`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla COLLABORATE
CREATE TABLE `gmm961617`.`Collaborate` ( 
    `collaboration_id` INT NOT NULL AUTO_INCREMENT, 
    `collab-invest-email` VARCHAR(100) NOT NULL, 
    `project_cod` VARCHAR(50) NOT NULL, 
    PRIMARY KEY (`collab-invest-email`, `project_cod`), 
    INDEX (`collaboration_id`),
    FOREIGN KEY (`collab-invest-email`) REFERENCES `User`(`email`) ON DELETE CASCADE,
    FOREIGN KEY (`project_cod`) REFERENCES `Project-Investigate`(`cod`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla PUBLICATION-HAVE
CREATE TABLE `gmm961617`.`Publication-Have` ( 
    `pub_id` INT NOT NULL AUTO_INCREMENT, 
    `doi` VARCHAR(200) NOT NULL, 
    `title` VARCHAR(200) NOT NULL, 
    `date` DATE NOT NULL, 
    `project_cod` VARCHAR(50) NOT NULL,
    `abstract` VARCHAR(1000) NULL DEFAULT NULL, 
    `keywords` VARCHAR(100) NULL DEFAULT NULL, 
    `url` VARCHAR(100) NOT NULL, 
    `non-group-authors` VARCHAR(300) NULL DEFAULT NULL, 
    `subtype` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`doi`), 
    INDEX (`pub_id`),
    FOREIGN KEY (`project_cod`) REFERENCES `Project-Investigate`(`cod`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla EDIT
CREATE TABLE `gmm961617`.`Edit` ( 
    `edit_id` INT NOT NULL AUTO_INCREMENT, 
    `author-email` VARCHAR(100) NOT NULL, 
    `pub-doi` VARCHAR(200) NOT NULL, 
    PRIMARY KEY (`author-email`, `pub-doi`), 
    INDEX (`edit_id`),
    FOREIGN KEY (`author-email`) REFERENCES `User`(`email`) ON DELETE CASCADE,
    FOREIGN KEY (`pub-doi`) REFERENCES `Publication-Have`(`doi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla ARTICLE
CREATE TABLE `gmm961617`.`Article` ( 
    `article_id` INT NOT NULL AUTO_INCREMENT, 
    `doi` VARCHAR(200) NOT NULL, 
    `journal` VARCHAR(150) NOT NULL,
    `volume` VARCHAR(50) NOT NULL, 
    `pages` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`doi`), 
    INDEX (`article_id`),
    FOREIGN KEY (`doi`) REFERENCES `Publication-Have`(`doi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla BOOK
CREATE TABLE `gmm961617`.`Book` ( 
    `book_id` INT NOT NULL AUTO_INCREMENT, 
    `doi` VARCHAR(200) NOT NULL, 
    `publisher` VARCHAR(150) NOT NULL,
    `editors` VARCHAR(300) NULL, 
    `isbn` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`doi`), 
    INDEX (`book_id`),
    FOREIGN KEY (`doi`) REFERENCES `Publication-Have`(`doi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla BOOKCHAPTER
CREATE TABLE `gmm961617`.`BookChapter` ( 
    `chapter_id` INT NOT NULL AUTO_INCREMENT, 
    `doi` VARCHAR(200) NOT NULL, 
    `book-title` VARCHAR(200) NOT NULL,
    `publisher` VARCHAR(150) NOT NULL,
    `editors` VARCHAR(300) NULL, 
    `isbn` VARCHAR(100) NOT NULL,
    `pages` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`doi`), 
    INDEX (`chapter_id`),
    FOREIGN KEY (`doi`) REFERENCES `Publication-Have`(`doi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Creación tabla CONFERENCE
CREATE TABLE `gmm961617`.`Conference` ( 
    `conference_id` INT NOT NULL AUTO_INCREMENT, 
    `doi` VARCHAR(200) NOT NULL, 
    `name` VARCHAR(200) NOT NULL,
    `place` VARCHAR(200) NOT NULL,
    `review` VARCHAR(100) NULL, 
    PRIMARY KEY (`doi`), 
    INDEX (`conference_id`),
    FOREIGN KEY (`doi`) REFERENCES `Publication-Have`(`doi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;