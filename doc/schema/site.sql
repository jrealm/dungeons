
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

