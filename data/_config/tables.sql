CREATE TABLE auth.users (
    id int primary key,
    email varchar(255) NOT NULL,
    password BINARY(64) NOT NULL,
    role int default 0,
    created_at timestamp,
    updated_at timestamp
);

CREATE TABLE auth.codes(
    id int primary key,
    code varchar(10) NOT NULL,
    user_id int foreign key(auth.users.id),
    valid int default 1,
    created_at timestamp,
    updated_at timestamp
);

CREATE TABLE auth.login_history(
    id primary key,
    user_id integer,
    ip_address varchar(255),
    device_info varchar(255),
    session_token varchar(255),
    session_active integer default 0,
    created_at timestamp,
    updated_at timestamp
)