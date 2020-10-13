
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

