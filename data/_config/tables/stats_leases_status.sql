-- view for tracking status statistics of issued books
create view stats_leases_status as 
(select status, count(*) as amount from library_leases group by status);
