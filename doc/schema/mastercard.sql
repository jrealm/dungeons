
CREATE TABLE base_master_card (
    id            INTEGER   NOT NULL PRIMARY KEY,
    member_id     INTEGER       NULL,
    card_number   TEXT      NOT NULL,
    valid_from    TEXT          NULL,
    good_thru     TEXT          NULL,
    security_code TEXT          NULL,
    modify_time   TIMESTAMP NOT NULL,
    status        INTEGER   NOT NULL  -- 0:尚未送審, 1:審核中, 2:通過, 3:拒絕
);

CREATE TABLE base_member_passport_auth (
    id             INTEGER   NOT NULL PRIMARY KEY,
    member_id      INTEGER   NOT NULL,
    mail           TEXT      NOT NULL,
    last_name      TEXT      NOT NULL,
    first_name     TEXT      NOT NULL,
    id_number      TEXT      NOT NULL,
    photocopy1     TEXT      NOT NULL,  -- 護照
    photocopy2     TEXT      NOT NULL,  -- 手持
    birthday       DATE      NOT NULL,
    nationality_id INTEGER   NOT NULL,
    sex            TEXT      NOT NULL,
    country_code   TEXT          NULL,
    town           TEXT          NULL,
    address        TEXT          NULL,
    post_code      TEXT          NULL,
    create_time    TIMESTAMP NOT NULL,
    language       TEXT          NULL,
    approver       TEXT          NULL,
    approve_time   TIMESTAMP     NULL,
    rejection      TEXT          NULL,
    status         INTEGER   NOT NULL   -- 1:審核中, 2:退回, 3:通過
);

