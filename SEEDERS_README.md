# Complete Database Seeders - Travel Shravel CRM

All seeders have been created and are ready to use. Run them in the following order:

## Quick Start

```bash
# Reset database and seed everything
php artisan migrate:fresh --seed
```

This will:
1. Drop all tables
2. Re-run migrations
3. Seed roles & permissions
4. Seed services (8 services)
5. Seed destinations (15 destinations)
6. Seed users (13 users with different roles)
7. Seed incentive rules (3 rules)
8. Seed leads (30 leads with complete data)

## Seeders Created

### 1. RolesAndPermissionsSeeder
- Creates 12 roles with proper permissions
- Assigns permissions to each role
- Can be run independently

### 2. ServiceSeeder
- Creates 8 travel services:
  - Domestic Travel
  - International Travel
  - Honeymoon Packages
  - Adventure Tours
  - Pilgrimage Tours
  - Beach Holidays
  - Family Packages
  - Corporate Travel

### 3. DestinationSeeder
- Creates 15 destinations:
  - Domestic: Goa, Kerala, Manali, Rajasthan, Kashmir, Darjeeling
  - International: Dubai, Bangkok, Singapore, Maldives, Bali, Switzerland, Paris, London, Tokyo

### 4. UserSeeder
- Creates 13 users (one for each role):
  - 1 Admin
  - 1 Sales Manager
  - 3 Sales persons
  - 1 Operation Manager
  - 1 Operation
  - 1 Accounts Manager
  - 1 Accounts
  - 1 Post Sales Manager
  - 1 Post Sales
  - 1 Delivery Manager
  - 1 Delivery
  - 1 HR
- All passwords: `password123`
- All users assigned to their respective roles

### 5. IncentiveRuleSeeder
- Creates 3 incentive rules:
  - Default Sales Commission (5% fixed, active)
  - Tiered Commission Structure (3-10% based on profit, inactive)
  - Fixed Bonus Promotion (₹5000 fixed, inactive)

### 6. LeadSeeder
- Creates 30 sample leads
- Each lead has:
  - Random service and destination
  - Random customer data
  - Random status (new, contacted, follow_up, priority, booked, closed)
  - Assigned to random sales user
- For booked leads:
  - Multiple payment installments
  - Cost components (hotel, transport, visa, etc.)
  - Operation records (some with approval requirements)
  - Documents (passport, visa, tickets, etc.)
  - Delivery assignments
  - Auto-calculated incentives

## Test Data Statistics

After running all seeders:
- **8 Services**
- **15 Destinations**
- **13 Users** (with roles)
- **3 Incentive Rules**
- **30 Leads** (with complete CRM data)
- **~50+ Payments** (across booked leads)
- **~60+ Cost Components**
- **~15 Operations** (some requiring approval)
- **~40+ Documents**
- **~15 Deliveries**
- **~10 Incentives**

## Login Credentials

All users have password: `password123`

| Email | Role |
|-------|------|
| admin@travelshravel.com | Admin |
| salesmanager@travelshravel.com | Sales Manager |
| priya@travelshravel.com | Sales |
| raj@travelshravel.com | Sales |
| opsmanager@travelshravel.com | Operation Manager |
| accountsmanager@travelshravel.com | Accounts Manager |
| postsalesmanager@travelshravel.com | Post Sales Manager |
| deliverymanager@travelshravel.com | Delivery Manager |
| hr@travelshravel.com | HR |

## Usage Examples

```bash
# Fresh start (recommended for development)
php artisan migrate:fresh --seed

# Seed only specific data
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=DestinationSeeder
php artisan db:seed --class=LeadSeeder

# Seed users with roles (after RolesAndPermissionsSeeder)
php artisan db:seed --class=UserSeeder
```

## Notes

- TSQ numbers start from TSQ1600 (as per workflow spec)
- Lead seeder creates realistic test scenarios
- Some leads are booked with complete workflow data
- Some operations require admin approval (loss-making scenarios)
- Incentives are auto-calculated for profitable booked leads
- All relationships are properly maintained

