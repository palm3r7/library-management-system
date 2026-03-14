USE librarymanagementdb;
SELECT name
FROM borrowers
INNER JOIN borrow
ON borrowers.name = borrow.borrower_id;