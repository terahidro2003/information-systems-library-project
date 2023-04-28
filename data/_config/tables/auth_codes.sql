CREATE TABLE auth_codes(
    id int primary key AUTO_INCREMENT,
    code varchar(10) NOT NULL,
    user_id int,
    valid int,
    created_at timestamp,
    updated_at timestamp,
    deleted_at timestamp
);