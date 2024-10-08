# modules entity from task
create table permission_groups
(
    id   int auto_increment
        primary key,
    name varchar(255) unique not null
);

# functions entity from task
create table permissions
(
    id                  int auto_increment
        primary key,
    name                varchar(255) unique not null,
    permission_group_id int                 not null,
    FOREIGN KEY (permission_group_id) REFERENCES permission_groups (id)
);

# user groups entity from task
create table user_groups
(
    id   int auto_increment
        primary key,
    name varchar(255) unique not null
);

# pivot table between permission groups and user groups
create table permission_group_user_groups
(
    permission_group_id int not null,
    user_group_id       int not null,
    PRIMARY KEY (permission_group_id, user_group_id),
    FOREIGN KEY (permission_group_id) REFERENCES permission_groups (id),
    FOREIGN KEY (user_group_id) REFERENCES user_groups (id)
);

# pivot table between permissions and user groups
create table permission_user_groups
(
    permission_id int not null,
    user_group_id int not null,
    PRIMARY KEY (permission_id, user_group_id),
    FOREIGN KEY (permission_id) REFERENCES permissions (id),
    FOREIGN KEY (user_group_id) REFERENCES user_groups (id)
);

create table users
(
    id       int auto_increment
        primary key,
    name     varchar(255) not null,
    group_id int          null,
    FOREIGN KEY (group_id) REFERENCES user_groups (id)
);

# pivot table between permission groups and users
create table permission_group_users
(
    user_id             int not null,
    permission_group_id int not null,
    PRIMARY KEY (user_id, permission_group_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (permission_group_id) REFERENCES permission_groups (id)
);


# fill database with test data from example
insert into permission_groups (name)
values ('Module 1'),
       ('Module 2');

insert into permissions (name, permission_group_id)
values ('Function 1', 1),
       ('Function 2', 1),
       ('Function 3', 2),
       ('Function 4', 2);

insert into user_groups (name)
values ('Group 1'),
       ('Group 2');

insert into users (name, group_id)
values ('User 1', 1),
       ('User 2', 1),
       ('User 3', 2),
       ('User 4', 2);

insert into permission_group_user_groups (permission_group_id, user_group_id)
values (1, 1);

insert into permission_user_groups (permission_id, user_group_id)
values (4, 2);

insert into permission_group_users (user_id, permission_group_id)
values (4, 2);