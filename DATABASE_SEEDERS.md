# Database Seeders Guide

This document explains how to use the database seeders to populate your Travel Shravel CRM with test data.

## Available Seeders

1. **RolesAndPermissionsSeeder** - Creates all roles and permissions (Admin, Sales, Operations, etc.)
2. **ServiceSeeder** - Creates 8 travel services (Domestic, International, Honeymoon, etc.)
3. **DestinationSeeder** - Creates 15 destinations (Goa, Kerala, Dubai, Bangkok, etc.)
4. **UserSeeder** - Creates 13 users with different roles (all with password: `password123`)
5. **IncentiveRuleSeeder** - Creates 3 incentive rules (Fixed %, Tiered %, Fixed Amount)
6. **LeadSeeder** - Creates 30 sample leads with:
   - Lead remarks
   - Payments (multiple installments)
   - Cost components
   - Operations records
   - Documents
   - Deliveries
   - Incentives

## How to Run Seeders

### Run All Seeders (Recommended)
```bash
php artisan migrate:fresh --seed
```
This will:
- Drop all tables
- Re-run all migrations
- Run all seeders in the correct order

### Run Individual Seeders
```bash
# Seed roles and permissions first (required!)
php artisan db:seed --class=RolesAndPermissionsSeeder

# Then seed other data
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=DestinationSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=IncentiveRuleSeeder
php artisan db:seed --class=LeadSeeder
```

### Run DatabaseSeeder (runs all seeders in order)
```bash
php artisan db:seed
```

## Default Login Credentials

After seeding, you can login with any of these users (password: `password123`):

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@travelshravel.com | password123 |
| Sales Manager | salesmanager@travelshravel.com | password123 |
| Sales | priya@travelshravel.com | password123 |
| Sales | raj@travelshravel.com | password123 |
| Sales | anita@travelshravel.com | password123 |
| Operation Manager | opsmanager@travelshravel.com | password123 |
| Accounts Manager | accountsmanager@travelshravel.com | password123 |
| Post Sales Manager | postsalesmanager@travelshravel.com | password123 |
| Delivery Manager | deliverymanager@travelshravel.com | password123 |
| HR | hr@travelshravel.com | password123 |

## Sample Data Created

- **8 Services**: Domestic Travel, International Travel, Honeymoon Packages, etc.
- **15 Destinations**: Goa, Kerala, Manali, Dubai, Bangkok, Singapore, Maldives, etc.
- **13 Users**: One for each role with proper permissions
- **3 Incentive Rules**: Default 5% commission, Tiered structure, Fixed bonus
- **30 Leads**: With various statuses (new, contacted, follow_up, priority, booked, closed)
- **Payments**: Multiple installments for booked leads
- **Cost Components**: Hotel, transport, visa, insurance costs
- **Operations**: With approval workflows for loss-making leads
- **Documents**: Passport, visa, ticket, voucher uploads
- **Deliveries**: Assigned deliveries with tracking
- **Incentives**: Auto-calculated incentives for profitable booked leads

## Notes

- All users have the password: `password123`
- TSQ numbers start from TSQ1600 (as per spec)
- Lead seeder creates realistic relationships between all modules
- Some leads are booked with complete data (payments, costs, operations, documents, deliveries, incentives)
- Some leads are in various stages (new, contacted, follow_up, etc.)

## Troubleshooting

If you get errors:
1. Make sure migrations are run first: `php artisan migrate`
2. Run RolesAndPermissionsSeeder first before other seeders
3. Run ServiceSeeder and DestinationSeeder before LeadSeeder
4. Check database connection in `.env`

