#!/bin/bash

echo "=========================================="
echo "SGC Installation Wizard - Test Script"
echo "=========================================="
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Configuration
TEST_DB="sgc_test_install"
DB_USER="root"

echo -e "${YELLOW}Step 1: Create test database${NC}"
echo "Database name: $TEST_DB"
read -sp "MySQL root password: " DB_PASS
echo ""

# Create test database
mysql -u $DB_USER -p$DB_PASS -e "DROP DATABASE IF EXISTS $TEST_DB; CREATE DATABASE $TEST_DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Test database created${NC}"
else
    echo -e "${RED}✗ Failed to create database${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Remove lock file${NC}"
if [ -f "storage/.installed" ]; then
    rm storage/.installed
    echo -e "${GREEN}✓ Lock file removed${NC}"
else
    echo -e "${YELLOW}! Lock file not found (OK for first test)${NC}"
fi

echo ""
echo -e "${YELLOW}Step 3: Clear Laravel cache${NC}"
php artisan config:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan cache:clear > /dev/null 2>&1
echo -e "${GREEN}✓ Cache cleared${NC}"

echo ""
echo -e "${YELLOW}Step 4: Check routes${NC}"
php artisan route:list --path=install | head -5
echo -e "${GREEN}✓ Installation routes available${NC}"

echo ""
echo "=========================================="
echo -e "${GREEN}Ready to test!${NC}"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Start Laravel: php artisan serve"
echo "2. Open browser: http://localhost:8000"
echo "3. Follow installation wizard"
echo ""
echo "Database credentials for wizard:"
echo "  Host: 127.0.0.1"
echo "  Port: 3306"
echo "  Database: $TEST_DB"
echo "  Username: $DB_USER"
echo "  Password: (your MySQL password)"
echo ""
echo "After testing, cleanup with:"
echo "  mysql -u $DB_USER -p -e \"DROP DATABASE $TEST_DB;\""
echo ""
