-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `send-email`;
CREATE DATABASE `send-email`;
USE `send-email`;

create table sender
(
    id int auto_increment
        primary key,
    `key` varchar(255) not null,
    host varchar(255) not null,
    port int not null,
    sender varchar(255) null,
    username varchar(255) not null,
    password varchar(255) not null
);

create table client
(
    id int auto_increment
        primary key,
    `key` varchar(255) not null,
    senderId int not null,
    name varchar(255) not null,
    email varchar(255) not null,
    constraint `key`
        unique (`key`),
    constraint client_ibfk_1
        foreign key (senderId) references sender (id)
);

create index senderId
    on client (senderId);

create table template
(
    id int auto_increment
        primary key,
    templateName varchar(255) not null,
    client int not null,
    template text not null,
    subject varchar(255) not null,
    type varchar(255) null,
    constraint client_templatename_unique_index
        unique (client, templateName),
    constraint template_ibfk_1
        foreign key (client) references client (id)
);

create table audit
(
    id int auto_increment
        primary key,
    template int not null,
    lastUsedDate datetime default CURRENT_TIMESTAMP not null,
    result tinyint(1) null,
    constraint audit_ibfk_1
        foreign key (template) references template (id)
);

create table users
(
    id int auto_increment
        primary key,
    user varchar(255) not null,
    password varchar(255) not null,
    isActive tinyint(1) default 1 null
);

create index template
    on audit (template);

create index client
    on template (client);

