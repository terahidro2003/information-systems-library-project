create view view_books_with_covers as 
(select library_books.id, library_books.title, library_books.description, library_books.quantity, library_books.year_published, library_books.added_by_user, library_books.ISBN_type, library_books.ISBN_identifier, library_books.language, library_books.type, library_books.created_at, library_books.updated_at, files.name, files.type as "filetype", files.added_by from library_books inner join files on library_books.cover_image_id = files.id);


