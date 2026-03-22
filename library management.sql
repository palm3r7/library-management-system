USE librarymanagementdb;
UPDATE borrow 
SET return_date = NULL 
WHERE return_date = '0000-00-00';