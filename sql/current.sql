alter table orders add column user_id int not null;

alter table orders add constraint foreign  key
fk_orders_users (user_id) references users(id)
on update restrict on delete restrict ;

insert into users(first_name, last_name, login, password, phone_number)
VALUES ('Admin', 'Admin', 'admin', '112233', '+77005554797');
alter table users_roles add unique index ui_users_roles (user_id , role_id) ;

