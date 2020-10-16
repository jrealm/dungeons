
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

