
CREATE TABLE base_wallet (
    id          INTEGER          NOT NULL PRIMARY KEY,
    member_id   INTEGER          NOT NULL,
    account     TEXT             NOT NULL,
    currency_id INTEGER          NOT NULL,
    balance     DOUBLE PRECISION NOT NULL,
    frozen      DOUBLE PRECISION NOT NULL
);

CREATE SEQUENCE base_transaction_bill_number;

CREATE TABLE base_transaction (
    id              INTEGER          NOT NULL PRIMARY KEY,
    bill_number     TEXT             NOT NULL,
    the_date        DATE             NOT NULL,
    type            INTEGER          NOT NULL, -- (message/tw/options/transaction-type.php)
    mode            INTEGER              NULL, -- 1:充值, 2:轉出
    wallet_id       INTEGER          NOT NULL,
    amount          DOUBLE PRECISION NOT NULL,
    fee             DOUBLE PRECISION NOT NULL,
    target          TEXT                 NULL, -- 110:交易序號, 202:卡號
    target_currency TEXT                 NULL,
    target_amount   DOUBLE PRECISION     NULL,
    target_fee      DOUBLE PRECISION     NULL,
    payment         TEXT                 NULL, -- 付款資訊
    request         TEXT                 NULL,
    response        TEXT                 NULL,
    notice          TEXT                 NULL,
    remark          TEXT                 NULL,
    creator         TEXT             NOT NULL,
    create_time     TIMESTAMP        NOT NULL,
    processor       TEXT                 NULL,
    process_time    TIMESTAMP            NULL,
    rejection       TEXT                 NULL,
    status          INTEGER          NOT NULL  -- 0:未入帳, 1:已入帳, 2:取消
);

CREATE TABLE base_wallet_log (
    id             INTEGER          NOT NULL PRIMARY KEY,
    wallet_id      INTEGER          NOT NULL,
    the_date       DATE             NOT NULL,
    transaction_id INTEGER          NOT NULL,
    type           INTEGER          NOT NULL, -- 1:轉出, 2:轉入
    debit          DOUBLE PRECISION NOT NULL, -- 轉入(借)(+)
    credit         DOUBLE PRECISION NOT NULL, -- 轉出(貸)(-)
    balance        DOUBLE PRECISION NOT NULL,
    remark         TEXT                 NULL,
    create_time    TIMESTAMP        NOT NULL
);

CREATE VIEW base_monthly_balance AS
     SELECT wallet_id AS id,
            SUM(debit) AS debit,
            SUM(credit) AS credit
       FROM base_wallet_log
      WHERE create_time > LOCALTIMESTAMP - INTERVAL '1 month'
   GROUP BY wallet_id;

CREATE TABLE base_erc20_wallet (
    id          INTEGER   NOT NULL PRIMARY KEY,
    member_id   INTEGER   NOT NULL,
    address     TEXT      NOT NULL,
    public_key  TEXT      NOT NULL,
    private_key TEXT      NOT NULL,
    create_time TIMESTAMP NOT NULL
);

CREATE TABLE base_erc20_transaction (
    id       INTEGER          NOT NULL PRIMARY KEY,
    hash     TEXT             NOT NULL UNIQUE,
    sender   TEXT             NOT NULL,
    receiver TEXT             NOT NULL,
    currency TEXT             NOT NULL,
    amount   DOUBLE PRECISION NOT NULL,
    status   INTEGER          NOT NULL  -- 0:處理中, 1:成功, 2:失敗
);

CREATE TABLE base_usdt_log (
    id          INTEGER          NOT NULL PRIMARY KEY,
    hash        TEXT             NOT NULL UNIQUE,
    sender      TEXT             NOT NULL,
    receiver    TEXT             NOT NULL,
    amount      DOUBLE PRECISION NOT NULL,
    create_time TIMESTAMP        NOT NULL
);

