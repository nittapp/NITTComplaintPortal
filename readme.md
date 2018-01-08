# NITT complaint portal
This is the API for the NITT complaint portal built with PHP using Laravel framework.

## Requirements
1. Laravel 5.5

## API endpoints
1. `get` `/api/v1/complaints`: get complaints of user. <br/>
      <i>params</i><br/>
    `start_date` - date filter for the starting date of complaints <br/>
    `end_date` - date filter for ending date of complaints <br/>
2. `get` `/api/v1/admin/complaints`: get complaints of all users. <br/>
      <i>params</i><br/>
    `start_date` - date filter for the starting date of complaints <br/>
    `end_date` - date filter for ending date of complaints <br/>
    `hostel` -  filter for hostel related complaints <br/>
    `status` -  filter for status of complaints <br/>
    
    
## Internal Codes

### Exception codes
<b>`1`</b> : user not logged in / session not set / session not found <br/>
<b>`2`</b> : permission not valid <br/>
