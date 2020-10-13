
/*
 *  DB_NAME=""
 *  DB_USER=""
 *
 *  createuser "${DB_USER}" --no-createrole --no-createdb --no-inherit --no-superuser -U postgres
 *  createdb "${DB_NAME}" --owner="${DB_USER}" -U postgres
 *
 *  psql -d "${DB_NAME}" -U "${DB_USER}"
 */

\i schema/base.sql
\i schema/user.sql
\i schema/file.sql
\i schema/site.sql
\i schema/member.sql
\i schema/wallet.sql

