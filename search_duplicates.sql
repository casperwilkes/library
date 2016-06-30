-- Select all duplicates from table --
SELECT tags.tag_name
FROM tags
INNER JOIN (
    SELECT tag_name
    FROM tags
    GROUP BY tag_name
    HAVING COUNT( tag_name ) >1
)dup ON tags.tag_name = dup.tag_name
ORDER BY tag_name ASC 
