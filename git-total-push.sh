#/bin/sh
schema=dbversion/crmschema.sql
dat=dbversion/crmdata.sql
acos=dbversion/crmacos.sql

echo "Exporting all database schema"
mysqldump -u root -pmasterkey crm --no-data > "$schema"

echo "Exporting all database data"
mysqldump -u root -pmasterkey crm --no-create-info > "$dat"

echo "Exporting acos"
mysqldump -u root -pmasterkey crm acos > "$acos"

echo "Adding schema to git"
git add "$schema"

echo "Adding database data to git"
git add "$dat"
#Commit
echo "Committing"
git commit -m "Database versioning commit ::automated::"
#Push
