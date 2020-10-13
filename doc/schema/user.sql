
CREATE TABLE base_group (
    id    INTEGER NOT NULL PRIMARY KEY,
    title TEXT        NULL UNIQUE
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

