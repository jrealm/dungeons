
/*
 *  DB_NAME=""
 *  DB_USER=""
 *
 *  createuser "${DB_USER}" --no-createrole --no-createdb --no-inherit --no-superuser -U postgres
 *  createdb "${DB_NAME}" --owner="${DB_USER}" -U postgres
 *
 *  psql -d "${DB_NAME}" -U "${DB_USER}"
 */

CREATE SEQUENCE base_id START WITH 100000000;

CREATE SEQUENCE base_manipulation;

CREATE SEQUENCE base_ranking START WITH 10000;

CREATE TABLE base_manipulation_log (
    id        INTEGER   NOT NULL PRIMARY KEY DEFAULT NEXTVAL('base_manipulation'),
    type      INTEGER   NOT NULL,
    log_time  TIMESTAMP NOT NULL DEFAULT LOCALTIMESTAMP(0),
    action    TEXT      NOT NULL,
    user_id   INTEGER       NULL,
    member_id INTEGER       NULL,
    ip        TEXT          NULL,
    data_type TEXT      NOT NULL,
    data_id   INTEGER   NOT NULL,
    previous  TEXT          NULL,
    current   TEXT          NULL
);

CREATE TABLE base_file (
    id            INTEGER   NOT NULL PRIMARY KEY,
    parent_id     INTEGER       NULL,
    type          INTEGER   NOT NULL,   -- 1:目錄, 2:檔案
    name          TEXT      NOT NULL,
    path          TEXT          NULL UNIQUE,
    size          BIGINT        NULL,
    description   TEXT          NULL,
    mime_type     TEXT          NULL,
    width         INTEGER       NULL,
    height        INTEGER       NULL,
    seconds       INTEGER       NULL,
    privilege     INTEGER   NOT NULL,   -- 1:公開, 2:前後台, 3:後台, 4:群組, 5:個人, 9:隱藏
    owner_id      INTEGER   NOT NULL,
    group_id      INTEGER       NULL,
    modified_time TIMESTAMP NOT NULL,
    deleted       BOOLEAN   NOT NULL
);

CREATE TABLE base_user (
    id          INTEGER NOT NULL PRIMARY KEY,
    username    TEXT    NOT NULL UNIQUE,
    password    TEXT    NOT NULL,
    group_id    INTEGER     NULL,
    begin_date  DATE        NULL,
    expire_date DATE        NULL,
    disabled    BOOLEAN NOT NULL
);

INSERT INTO base_user VALUES (1,'admin','?',1,CURRENT_DATE,null,false);

-- UPDATE base_user SET password = MD5(id || '::' || 'password') WHERE id = 1;

CREATE TABLE base_group (
    id    INTEGER NOT NULL PRIMARY KEY,
    title TEXT    NOT NULL UNIQUE
);

INSERT INTO base_group VALUES (1,'系統管理員');

CREATE TABLE base_member (
    id       INTEGER NOT NULL PRIMARY KEY,
    username TEXT    NOT NULL UNIQUE,
    nickname TEXT    NOT NULL UNIQUE,
    password TEXT    NOT NULL,
    disabled BOOLEAN NOT NULL
);
