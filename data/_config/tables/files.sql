CREATE TABLE files(
    id int primary key AUTO_INCREMENT,
    type varchar(255),
    name varchar(255),
    added_by int,
    created_at timestamp
);