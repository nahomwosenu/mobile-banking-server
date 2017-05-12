use bank;
create table customer(
 id varchar(255) primary key,
 firstname varchar(255),
 lastname varchar(255),
 middlename varchar(255),
 age int,
 sex varchar(20),
 address varchar(255),
 username varchar(255)
);
create table manager(
 id varchar(255) primary key,
 firstname varchar(255),
 lastname varchar(255),
 middlename varchar(255),
 age varchar(255),
 sex varchar(255),
 username varchar(255),
 account_no varchar(255)
);
create table user(
 account_no varchar(255) primary key,
 password varchar(255),
 type varchar(255)
);
create table account(
 account_no varchar(255) primary key,
 balance varchar(255)
);
create table USSD(
 account_no varchar(255),
 pin varchar(10)
);
create table report(
 report_id varchar(255),
 date_generated varchar(255),
 transaction_type varchar(255),
 detail varchar(255)
);
