create view view_books_with_covers as 
(select library_books.id, library_books.title, library_books.author, library_books.description, library_books.quantity, library_books.year_published, library_books.added_by_user, library_books.ISBN_identifier, library_books.language, library_books.type, library_books.created_at, library_books.updated_at, files.name, files.type as "filetype", files.added_by from library_books inner join files on library_books.cover_image_id = files.id);


create view view_leases as (select title, author, library_leases.id, status, deadline, auth_users.email from library_books inner join library_leases on library_leases.book_id = library_books.id inner join auth_users on auth_users.id = library_leases.user_id);