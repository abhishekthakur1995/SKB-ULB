CREATE TABLE candidate_list (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    guardian VARCHAR(50) NOT NULL,
    permanentAddress VARCHAR(100) NOT NULL,
    temporaryAddress VARCHAR(100) DEFAULT NULL,
    phoneNumber VARCHAR(15) DEFAULT NULL,
    birthPlace VARCHAR(50) DEFAULT NULL,
    gender VARCHAR(20) NOT NULL,
    district VARCHAR(30) NOT NULL,
    ulbRegion VARCHAR(30) NOT NULL,
    maritialStatus VARCHAR(20) NOT NULL,
    dob VARCHAR(30) NOT NULl,
    category VARCHAR(20) NOT NULL,
    receiptNumber VARCHAR(20) NOT NULL UNIQUE,
    religion VARCHAR(20) NOT NULL,
    userFormValid TINYINT(1) NOT NULL DEFAULT 0,
    remark TEXT DEFAULT NULL,
    status TINYINT(1) NOT NULL DEFAULT 0,
    seedNumber varchar(10) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ulb_admins (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    region VARCHAR(50) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,
    role ENUM('ULBADMIN', 'SUPERADMIN') NOT NULL,
    firstLogin TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

<sql>ALTER TABLE ulb_admins ADD COLUMN firstLogin TINYINT(1) NOT NULL DEFAULT 0 AFTER role</sql>