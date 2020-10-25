# Suppression de la base de données
echo "Dropping database..."
php bin/console doctrine:database:drop --force

# Création de la base de données
echo "Database creation..."
php bin/console doctrine:database:create

# Migrations
echo "Migrations..."
php bin/console --no-interaction doctrine:migrations:migrate

# Autres modifications du schéma non présentes dans les entités
# (Certains bundles ont besoin de cette commande)
echo "Schema update..."
php bin/console doctrine:schema:update --force

# Fixtures
echo "Loading Fixtures..."
php bin/console doctrine:fixtures:load --no-debug

#echo "Création de l'utilisateur root, mot de passe root"
#php bin/console fos:user:create root@nowdigital.fr root@nowdigital.fr root
#php bin/console fos:user:promote root@nowdigital.fr ROLE_ROOT
#

echo "Database is ready"
echo ""
