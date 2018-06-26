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

DROP TABLE IF EXISTS selected_candidates;
CREATE TABLE selected_candidates (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ulbRegion varchar(30) NOT NULL,
    name VARCHAR(50) NOT NULL,
    receiptNumber VARCHAR(20) NOT NULL UNIQUE,
    category VARCHAR(20) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    maritialStatus VARCHAR(20) NOT NULL,
    specialPreference VARCHAR(50) DEFAULT NULL,
    code TINYINT(2) NOT NULL,
    seedNumber varchar(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)

DROP TABLE IF EXISTS lock_code_seed;
CREATE TABLE lock_code_seed (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ulbRegion varchar(30) NOT NULL,
    code TINYINT(2) NOT NULL,
    seedNumber varchar(10) NOT NULL
)

DROP TABLE IF EXISTS reservation_chart;
CREATE TABLE reservation_chart (
    ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ULB_REGION varchar(30) DEFAULT NULL UNIQUE,
    TOTAL_SEATS varchar(10) DEFAULT NULL,
    SC_FEMALE_WIDOW varchar(10) DEFAULT NULL,
    SC_FEMALE_DIVORCEE varchar(10) DEFAULT NULL,
    SC_FEMALE_COMMON varchar(10) DEFAULT NULL,
    ST_FEMALE_WIDOW varchar(10) DEFAULT NULL,
    ST_FEMALE_DIVORCEE varchar(10) DEFAULT NULL,
    ST_FEMALE_COMMON varchar(10) DEFAULT NULL,
    OBC_FEMALE_WIDOW varchar(10) DEFAULT NULL,
    OBC_FEMALE_DIVORCEE varchar(10) DEFAULT NULL,
    OBC_FEMALE_COMMON varchar(10) DEFAULT NULL,
    SPECIALOBC_FEMALE_WIDOW varchar(10) DEFAULT NULL,
    SPECIALOBC_FEMALE_DIVORCEE varchar(10) DEFAULT NULL,
    SPECIALOBC_FEMALE_COMMON varchar(10) DEFAULT NULL,
    GENERAL_FEMALE_WIDOW varchar(10) DEFAULT NULL,
    GENERAL_FEMALE_DIVORCEE varchar(10) DEFAULT NULL,
    GENERAL_FEMALE_COMMON varchar(10) DEFAULT NULL,
    SC_MALE varchar(10) DEFAULT NULL,
    ST_MALE varchar(10) DEFAULT NULL,
    OBC_MALE varchar(10) DEFAULT NULL,
    SPECIALOBC_MALE varchar(10) DEFAULT NULL,
    GENERAL_MALE varchar(10) DEFAULT NULL,
    TOTAL_GENERAL varchar(10) DEFAULT NULL,
    EXOFFICER varchar(10) DEFAULT NULL,
    SPORTSPERSON varchar(10) DEFAULT NULL,
    DISABLED varchar(10) DEFAULT NULL,
    DISCARDED_SEATS varchar(30) DEFAULT NULL,
    CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS login_attempts;
CREATE TABLE `login_attempts` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
    `attempts` int(11) DEFAULT '0',
    `lastlogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


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
<sql>ALTER TABLE candidate_list ENGINE = InnoDB;</sql>
<sql>ALTER TABLE ulb_admins ENGINE = InnoDB;</sql>
<sql>ALTER TABLE candidate_list ADD COLUMN specialPreference VARCHAR(50) DEFAULT NULL</sql>
<sql>ALTER TABLE candidate_list ADD COLUMN selected TINYINT(1) NOT NULL DEFAULT 0 AFTER status</sql>
<sql>ALTER TABLE candidate_list DROP COLUMN seedNumber</sql>
