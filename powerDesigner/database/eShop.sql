/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     27/12/2019 19:23:22                          */
/*==============================================================*/


drop table if exists Buyer;

drop table if exists Cart_item;

drop table if exists Orders;

drop table if exists Product;

drop table if exists Role;

drop table if exists Status;

drop table if exists Stock;

drop table if exists User;

/*==============================================================*/
/* Table: Buyer                                                 */
/*==============================================================*/
create table Buyer
(
   buyer_id             int not null auto_increment,
   user_id              int,
   adress               text not null,
   phone_number         text not null,
   primary key (buyer_id)
);

/*==============================================================*/
/* Table: Cart_item                                             */
/*==============================================================*/
create table Cart_item
(
   cartitem_id          int not null auto_increment,
   order_id             int,
   Product_id           int,
   quantity             int not null,
   primary key (cartitem_id)
);

/*==============================================================*/
/* Table: Orders                                                */
/*==============================================================*/
create table Orders
(
   order_id             int not null auto_increment,
   buyer_id             int,
   status_id            int,
   total                decimal(10,2) not null,
   date                 datetime not null,
   primary key (order_id)
);

/*==============================================================*/
/* Table: Product                                               */
/*==============================================================*/
create table Product
(
   Product_id           int not null auto_increment,
   stock_id             int,
   name                 text not null,
   price                decimal(10,2) not null,
   description          text not null,
   status               char(10),
   rate                 int,
   size                 int,
   color                text,
   material             text,
   primary key (Product_id)
);

/*==============================================================*/
/* Table: Role                                                  */
/*==============================================================*/
create table Role
(
   role_id              int not null auto_increment,
   name                 text not null,
   primary key (role_id)
);

/*==============================================================*/
/* Table: Status                                                */
/*==============================================================*/
create table Status
(
   status_id            int not null auto_increment,
   name                 text not null,
   primary key (status_id)
);

/*==============================================================*/
/* Table: Stock                                                 */
/*==============================================================*/
create table Stock
(
   stock_id             int not null auto_increment,
   quantity             int not null,
   primary key (stock_id)
);

/*==============================================================*/
/* Table: User                                                  */
/*==============================================================*/
create table User
(
   user_id              int not null auto_increment,
   role_id              int,
   firstname            text not null,
   lastname             text not null,
   email                text not null,
   password             text not null,
   active               bool not null,
   salt                 text not null,
   primary key (user_id)
);

alter table Buyer add constraint FK_FK_user_buyer2 foreign key (user_id)
      references User (user_id) on delete restrict on update restrict;

alter table Cart_item add constraint FK_FK_order_cart foreign key (order_id)
      references Orders (order_id) on delete restrict on update restrict;

alter table Cart_item add constraint FK_FK_product_cartItem foreign key (Product_id)
      references Product (Product_id) on delete restrict on update restrict;

alter table Orders add constraint FK_FK_buyer_order foreign key (buyer_id)
      references Buyer (buyer_id) on delete restrict on update restrict;

alter table Orders add constraint FK_FK_status_order foreign key (status_id)
      references Status (status_id) on delete restrict on update restrict;

alter table Product add constraint FK_FK_product_stock foreign key (stock_id)
      references Stock (stock_id) on delete restrict on update restrict;

alter table User add constraint FK_FK_role_user foreign key (role_id)
      references Role (role_id) on delete restrict on update restrict;

