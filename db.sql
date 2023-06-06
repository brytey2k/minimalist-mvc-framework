drop table if exists comments;
drop table if exists posts;
drop table if exists users;

create table users(
                      user_id int not null auto_increment primary key,
                      first_name varchar(100) not null,
                      last_name varchar(100) null,
                      username varchar(60) not null,
                      password varchar(60) not null,
                      status enum('active', 'inactive', 'deleted') default 'active',
                      created_at datetime not null,
                      index(username)
);

insert into users(first_name, last_name, username, password, created_at)
    value ('Bright', 'Nkrumah', 'bright', '$2y$10$Be85/niv.hFw6wklWEj3h.CVxTrMeXyIQqREGD6TFzxiD2Aa8lwHK', now());
# the password is 'password'

# leaving indexes out because I am not implementing search yet
create table posts(
                      post_id int not null auto_increment primary key,
                      title varchar(300) not null, # just in case someone chooses a long title
                        content text not null,
                        image varchar(500) not null,
                      author_id int not null,
                      created_at datetime not null,
                      foreign key (author_id) references users(user_id) on update cascade on delete no action
);

create table comments(
                         comment_id int not null auto_increment primary key,
                         name varchar(100) not null,
                         url varchar(150) null,
                         content text not null,
                         author_id int not null,
                         post_id int not null,
                         created_at datetime not null,
                         foreign key(author_id) references users(user_id) on update cascade on delete no action,
                         foreign key(post_id) references posts(post_id) on update cascade on delete cascade
);

alter table comments
add email varchar(150) null;