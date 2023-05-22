CREATE TABLE library_books(
    id int primary key AUTO_INCREMENT,
    title varchar(255), -- primary
    description varchar(255), -- primary
    quantity int, -- primary
    year_published int, 
    author_group_id int, -- we group authors as book can be written by multiple authors
    publisher_id int,
    added_by_user int, 
    ISBN_type varchar(255),
    ISBN_identifier varchar(255),
    page_count int,
    cover_image_id int,
    language varchar(255),
    type varchar(255), -- book can be either PRINT format or EBOOK format
    created_at timestamp,
    updated_at timestamp,
    deleted_at timestamp
);