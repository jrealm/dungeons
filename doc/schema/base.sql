
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

CREATE TABLE base_country (
    id      INTEGER NOT NULL PRIMARY KEY,
    title   TEXT    NOT NULL,
    code    TEXT    NOT NULL UNIQUE,
    prefix  TEXT    NOT NULL,
    ranking INTEGER NOT NULL
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

