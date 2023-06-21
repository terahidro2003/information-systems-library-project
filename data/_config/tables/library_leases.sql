-- Table for storing issued books information
create table library_leases(
    id int primary key AUTO_INCREMENT,
    book_id int,
    user_id int,
    status varchar(255),
    deadline timestamp,
    created_at timestamp,
    updated_at timestamp
);