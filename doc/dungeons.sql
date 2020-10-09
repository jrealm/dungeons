
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

CREATE SEQUENCE base_ranking START WITH 100 INCREMENT BY 100;

CREATE TABLE base_manipulation_log (
    id         INTEGER   NOT NULL PRIMARY KEY DEFAULT NEXTVAL('base_manipulation'),
    type       INTEGER   NOT NULL,
    log_time   TIMESTAMP NOT NULL DEFAULT LOCALTIMESTAMP(0),
    controller TEXT      NOT NULL,
    user_id    INTEGER       NULL,
    member_id  INTEGER       NULL,
    ip         TEXT          NULL,
    data_type  TEXT      NOT NULL,
    data_id    INTEGER   NOT NULL,
    previous   TEXT          NULL,
    current    TEXT          NULL
);

CREATE TABLE base_file (
    id            INTEGER   NOT NULL PRIMARY KEY,
    parent_id     INTEGER       NULL,
    type          INTEGER   NOT NULL,   -- 1:目錄, 2:檔案
    name          TEXT      NOT NULL,
    path          TEXT          NULL UNIQUE,
    size          BIGINT        NULL,
    hash          TEXT          NULL,
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

INSERT INTO base_user VALUES (1,'root','?',NULL,CURRENT_DATE,NULL,false);

-- UPDATE base_user SET password = MD5(id || '::' || 'password') WHERE id = 1;

CREATE TABLE base_user_log (
    id          INTEGER   NOT NULL PRIMARY KEY,
    user_id     INTEGER   NOT NULL,
    type        INTEGER   NOT NULL, -- 1:登入, 2:登出, 3:重設密碼, 4:密碼錯誤
    ip          TEXT      NOT NULL,
    create_time TIMESTAMP NOT NULL
);

CREATE TABLE base_group (
    id    INTEGER NOT NULL PRIMARY KEY,
    title TEXT        NULL UNIQUE
);

CREATE TABLE base_page (
    id           INTEGER   NOT NULL PRIMARY KEY,
    path         TEXT      NOT NULL UNIQUE,
    title        TEXT          NULL,
    enable_time  TIMESTAMP     NULL,
    disable_time TIMESTAMP     NULL
);

CREATE TABLE base_block (
    id           INTEGER   NOT NULL PRIMARY KEY,
    page_id      INTEGER   NOT NULL,
    module       TEXT      NOT NULL,
    name         TEXT      NOT NULL,
    title        TEXT          NULL,
    content      TEXT          NULL,
    image        TEXT          NULL,
    url          TEXT          NULL,
    extra        TEXT          NULL,
    enable_time  TIMESTAMP     NULL,
    disable_time TIMESTAMP     NULL,
    ranking      INTEGER   NOT NULL
);

CREATE TABLE base_block_item (
    id           INTEGER   NOT NULL PRIMARY KEY,
    block_id     INTEGER   NOT NULL,
    title        TEXT          NULL,
    content      TEXT          NULL,
    image        TEXT          NULL,
    url          TEXT          NULL,
    extra        TEXT          NULL,
    enable_time  TIMESTAMP     NULL,
    disable_time TIMESTAMP     NULL,
    ranking      INTEGER   NOT NULL
);

CREATE TABLE base_menu (
    id           INTEGER   NOT NULL PRIMARY KEY,
    type         INTEGER       NULL,
    parent_id    INTEGER       NULL,
    title        TEXT          NULL,
    icon         TEXT          NULL,
    url          TEXT          NULL,
    enable_time  TIMESTAMP     NULL,
    disable_time TIMESTAMP     NULL,
    ranking      INTEGER   NOT NULL
);

CREATE TABLE base_member (
    id               INTEGER NOT NULL PRIMARY KEY,
    username         TEXT    NOT NULL UNIQUE,
    nickname         TEXT        NULL UNIQUE,
    mobile           TEXT        NULL UNIQUE,
    password         TEXT    NOT NULL,
    payment_password TEXT        NULL,
    disabled         BOOLEAN NOT NULL
);

CREATE TABLE base_member_log (
    id          INTEGER   NOT NULL PRIMARY KEY,
    member_id   INTEGER   NOT NULL,
    type        INTEGER   NOT NULL, -- 1:登入, 2:登出, 3:重設密碼, 4:密碼錯誤, 5:忘記密碼, 6:重設交易密碼, 7:OTP登入
    ip          TEXT      NOT NULL,
    create_time TIMESTAMP NOT NULL
);

CREATE TABLE base_sms_log (
    id          INTEGER   NOT NULL PRIMARY KEY,
    sender      INTEGER       NULL,
    receiver    TEXT      NOT NULL,
    content     TEXT      NOT NULL,
    response    TEXT          NULL,
    ip          TEXT      NOT NULL,
    create_time TIMESTAMP NOT NULL,
    status      INTEGER   NOT NULL
);

CREATE TABLE base_currency (
    id           INTEGER   NOT NULL PRIMARY KEY,
    title        TEXT          NULL,
    code         TEXT      NOT NULL UNIQUE,
    symbol       TEXT          NULL,
    icon         TEXT          NULL,
    enable_time  TIMESTAMP     NULL,
    disable_time TIMESTAMP     NULL,
    ranking      INTEGER   NOT NULL
);

CREATE TABLE base_exchange_rate (
    id          INTEGER          NOT NULL PRIMARY KEY,
    base_id     INTEGER          NOT NULL,
    currency    TEXT             NOT NULL,
    buy         DOUBLE PRECISION NOT NULL,
    buy_profit  DOUBLE PRECISION NOT NULL,
    sell        DOUBLE PRECISION NOT NULL,
    sell_profit DOUBLE PRECISION NOT NULL,
    modify_time TIMESTAMP        NOT NULL,
    auto_modify BOOLEAN          NOT NULL
);

CREATE TABLE base_country (
    id      INTEGER NOT NULL PRIMARY KEY,
    title   TEXT        NULL,
    code    TEXT    NOT NULL UNIQUE,
    prefix  TEXT    NOT NULL,
    ranking INTEGER NOT NULL
);

