drop table if exists error_log;
CREATE TABLE error_log (
    id integer not null,
    level varchar(128) NOT NULL,
    category varchar(128) NULL,
    logtime timestamp  NULL,
    user_ip varchar(50) NULL,
    user_name varchar(50) NULL,
    request_url varchar(1024) NULL,
    message varchar(2048) NULL,
    CONSTRAINT pk_eror_log PRIMARY KEY(id)
);

drop sequence if exists error_log_id_seq;
CREATE SEQUENCE error_log_id_seq START 1;

DROP TABLE IF EXISTS audit;
CREATE TABLE audit (
  id bigint NOT NULL,
  date_time timestamp NOT NULL,
  object varchar(100) NOT NULL,
  operation varchar(100) NOT NULL,
  description varchar(512) DEFAULT NULL,
  user_id varchar(50) NOT NULL,
  CONSTRAINT pk_audit PRIMARY KEY(id)
);

drop sequence if exists audit_id_seq;
CREATE SEQUENCE audit_id_seq START 1;

DROP TABLE IF EXISTS sysparams;
CREATE TABLE sysparams (
  name varchar(64) NOT NULL,
  description varchar(1024) NULL,
  value varchar(512) NOT NULL,
  type varchar(64) NOT NULL,
  visible boolean NOT NULL,
  editable boolean NOT NULL,
  PRIMARY KEY (name)
);


DROP TABLE IF EXISTS AuthAssignment;
DROP TABLE IF EXISTS AuthItemChild;
DROP TABLE IF EXISTS AuthItem;

CREATE TABLE AuthItem (
  name varchar(64) NOT NULL,
  type bigint NOT NULL,
  description text,
  bizrule text,
  data text,
  PRIMARY KEY (name)
);

CREATE TABLE AuthItemChild (
  parent varchar(64) NOT NULL,
  child varchar(64) NOT NULL,
  PRIMARY KEY (parent,child),
  CONSTRAINT AuthItemChild_ibfk_1 FOREIGN KEY (parent) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT AuthItemChild_ibfk_2 FOREIGN KEY (child) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE AuthAssignment (
  itemname varchar(64) NOT NULL,
  userid varchar(64) NOT NULL,
  bizrule text,
  data text,
  PRIMARY KEY (itemname,userid),
  CONSTRAINT AuthAssignment_ibfk_1 FOREIGN KEY (itemname) REFERENCES AuthItem (name) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  nick varchar(64) NOT NULL,
  email varchar(64) NOT NULL UNIQUE,
  password varchar(64) NOT NULL,
  name varchar(100) DEFAULT NULL,
  surname varchar(100) DEFAULT NULL,
  last_login date DEFAULT NULL,
  enabled boolean DEFAULT NULL,
  role varchar(50) DEFAULT NULL,
  PRIMARY KEY (nick)
);

drop sequence if exists brand_id_seq;
CREATE SEQUENCE brand_id_seq START 1;

DROP TABLE IF EXISTS brands;
CREATE TABLE brands (
  id integer NOT NULL,
  name varchar(50) NOT NULL,
  nationality varchar(50) NOT NULL,
  location varchar(1024) NULL,
  founder varchar(50) NULL,
  foundation_year varchar(10) NULL,
  ceo varchar(50) NULL,
  webpage varchar(150) NULL,
  facebook varchar(150) NULL,
  linkedin varchar(150) NULL,
  googleplus varchar(150) NULL,
  tweeter varchar(150) NULL,
  instagram varchar(150) NULL,
  
  CONSTRAINT pk_brands PRIMARY KEY(id)
);

