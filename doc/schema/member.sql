
CREATE TABLE common_member (
    id                    INTEGER   NOT NULL PRIMARY KEY,
    username              TEXT      NOT NULL UNIQUE,
    nickname              TEXT          NULL UNIQUE,
    country_id            INTEGER       NULL,
    mobile                TEXT          NULL UNIQUE,
    mail                  TEXT          NULL UNIQUE,
    password              TEXT      NOT NULL,
    password_time         TIMESTAMP NOT NULL,
    payment_password      TEXT          NULL,
    payment_password_time TIMESTAMP     NULL,
    create_time           TIMESTAMP NOT NULL,
    disabled              BOOLEAN   NOT NULL
);

CREATE TABLE base_member () INHERITS (common_member);

CREATE TABLE base_member_log (
    id          INTEGER   NOT NULL PRIMARY KEY,
    member_id   INTEGER   NOT NULL,
    type        INTEGER   NOT NULL, -- 1:登入, 2:登出, 3:重設密碼, 4:密碼錯誤, 5:忘記密碼, 6:重設交易密碼, 7:OTP登入
    ip          TEXT      NOT NULL,
    create_time TIMESTAMP NOT NULL
);

