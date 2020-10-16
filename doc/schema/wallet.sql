
CREATE TABLE base_wallet (
    id          INTEGER          NOT NULL PRIMARY KEY,
    member_id   INTEGER          NOT NULL,
    account     TEXT             NOT NULL,
    currency_id INTEGER          NOT NULL,
    balance     DOUBLE PRECISION NOT NULL,
    frozen      DOUBLE PRECISION NOT NULL
);

CREATE TABLE base_transaction (
    id           INTEGER          NOT NULL PRIMARY KEY,
    wallet_id    INTEGER          NOT NULL,
    the_date     DATE             NOT NULL,
    type         INTEGER          NOT NULL,
    amount       DOUBLE PRECISION NOT NULL,
    fee          DOUBLE PRECISION NOT NULL,
    target       TEXT                 NULL,
    bank_code    TEXT                 NULL,
    bill_number  TEXT                 NULL,
    payment      TEXT                 NULL, -- 付款資訊
    request      TEXT                 NULL,
    response     TEXT                 NULL,
    notice       TEXT                 NULL,
    creator      TEXT             NOT NULL,
    create_time  TIMESTAMP        NOT NULL,
    remark       TEXT                 NULL,
    processor    TEXT                 NULL,
    process_time TIMESTAMP            NULL,
    rejection    TEXT                 NULL,
    status       INTEGER          NOT NULL  -- 0:未入帳, 1:已入帳, 2:取消
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

