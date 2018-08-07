Database structure is in database folder
Using plain php ,javascript,bootstrap for css,datatable for list view and fpdf for pdf generator.


Add employee Details,

  For adding the employee details
  
  Mandatory fields(Employee id,Name,Designation(can be chaged to dropdown),Age,Gender)
  
  NON Mandatory fields(Permenant address,temporary address,mobile,landline (no valiations as of now))
  
  Employee ID is unique(cant add the same Employee ID).
  
  Also saving dates added and dates modified details.
  
  
Report,

  Shows the 'count' for users/employees which have any of the NON mandatory filed(s) are field
  
  Can be grouped by Designation,Age(is in range),Gender
  
  Drilldown to show the list of Employees
  
  
Download Employee details

  Lists all the employees and can download the full details in PDF format
  
  'No edit/delete option added as of now'
  





Future Scope
1. Mobile number 10 digint validation
2. Edit/Delete option (already exisiting employee)
3. Menu links not getting highlignted during selection
4. Breadcrums not added
5. No results graph
6. highcharts links are CDN links(need to copy the files to server)
