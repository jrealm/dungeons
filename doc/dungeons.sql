
/*
 *  DB_NAME=""
 *  DB_USER=""
 *
 *  createuser "${DB_USER}" --no-createrole --no-createdb --no-inherit --no-superuser -U postgres
 *  createdb "${DB_NAME}" --owner="${DB_USER}" -U postgres
 *
 *  psql -d "${DB_NAME}" -U "${DB_USER}"
 */

\ir schema/base.sql
\ir schema/user.sql
\ir schema/file.sql
\ir schema/site.sql
\ir schema/member.sql
\ir schema/wallet.sql

