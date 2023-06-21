-- Table for storing session tokens and device info
-- Authentication table
CREATE TABLE auth_login_history(
    id int(11) NOT NULL AUTO_INCREMENT,
    user_id int,
    ip_address varchar(255),
    device_info varchar(255),
    session_token varchar(255),
    session_active integer default 0,
    created_at timestamp,
    updated_at timestamp,
    deleted_at timestamp default null,
    PRIMARY KEY (id)
);