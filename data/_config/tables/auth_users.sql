CREATE TABLE auth_users (
    id int primary key AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    password BINARY(64) NOT NULL,
    role int default 0,
    language varchar(2) default("en"),
    secondary_language varchar(2) default("lt"),
    created_at timestamp,
    updated_at timestamp,
    deleted_at timestamp
);