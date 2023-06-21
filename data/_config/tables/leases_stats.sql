-- view that selects how many leases (amount) were done in a each day of the month (date)
create view leases_stats as 
(select COUNT(*) as "amount", DAY(created_at) as "date" from library_leases group by DAY(created_at));
