-- Create a backup table and insert data from master table
CREATE TABLE `new_table` 
LIKE `old_table`; 
INSERT INTO `new_table` 
SELECT * FROM `old_table`;

-- Example -- 
CREATE TABLE `projects_04_06_15` LIKE `projects`;
INSERT INTO `projects_04_06_15`
SELECT *
FROM `projects`