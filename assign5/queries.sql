/*** 1 ***/
/* Write a query to display the last name, job, department number, and 
department name for all employees who work in Southlake. Be sure to 
handle case (i.e. upper and lower case) when checking that the city 
is Southlake - use a function to force a proper case comparison. Give 
the query in SQL:1999 and Oracle SQL. */

-- SQL:1999
SELECT e.last_name AS "Last Name", 
       job_title AS "Job",
       department_id AS "Dept No", 
       d.department_name AS "Department"
       FROM employees e INNER JOIN departments d
       USING (department_id)
       INNER JOIN jobs j
       USING (job_id)
       INNER JOIN locations l
       ON (d.location_id = l.location_id)
       WHERE UPPER(l.city) LIKE 'SOUTHLAKE';

-- Oracle SQL
SELECT e.last_name AS "Last Name",
       j.job_title AS "Job",
       e.department_id AS "Dept No", 
       d.department_name AS "Department"
       FROM employees e, departments d, jobs j, locations l
       WHERE e.department_id = d.department_id
       AND e.job_id = j.job_id
       AND d.location_id = l.location_id
       AND UPPER(l.city) LIKE 'SOUTHLAKE';


/*** 2 ***/
/* Write a query that will list all of the employees (last names), 
whose last name starts with 'G' (be sure to handle case - use a 
function), and the departments (give the name) to which they belong. 
Include all employees who have not yet been assigned to any department. 
Give the query in SQL:1999 and Oracle SQL. (Note: do not use IS NULL 
or IS NOT NULL in your query.) */

-- SQL:1999
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e LEFT OUTER JOIN departments d
       USING (department_id)
       WHERE UPPER(e.last_name) LIKE 'G%';

-- Notice, this won't work
-- Oracle SQL
SELECT e.last_name AS "Last Name",
       d.department_name AS "Department"
       FROM employees e, departments d
       WHERE (e.department_id = d.department_id(+))
       AND UPPER(e.last_name) LIKE 'G%';


/*** 3 ***/
/* Display the employee last name and employee number along with their 
manager's last name and manager number (in other words the manager's 
employee id) for all employees whose last name begins with 'T' (be 
sure to handle case - use a function). Label the columns Employee, 
Emp#, Manager, and Mgr#, respectively (note the use of upper and lower 
case). Give the query in SQL:1999 and Oracle SQL. */

-- SQL:1999
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e INNER JOIN employees m
       ON (e.manager_id = m.employee_id)
       WHERE UPPER(e.last_name) LIKE 'T%';

-- Oracle SQL
SELECT e.last_name AS "Employee",
       e.employee_id AS "Emp#",
       m.last_name AS "Manager",
       m.employee_id AS "Mgr#"
       FROM employees e, employees m
       WHERE (e.manager_id = m.employee_id)
       AND UPPER(e.last_name) LIKE 'T%';
