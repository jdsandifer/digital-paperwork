# Digital Paperwork Back End Improvements
After helping speed up the user interface, I continued to assist on the project. 

Most recently, we've been working to speed up the server side of the system.
In addition to general improvements, bug fixes, and refactoring, I've been focusing on 
a particular interface between the API and the database.

### A Slow API Makes for a Slow System
With the front end working much more quickly, the back end started being the bottleneck in the system.

Specifically, one function that was in charge of updating the database was really bogging things down.
It had to be called once for every item that was being changed and it ran multiple SQL commands each time.
This high humber of SQL commands seemed to be what was eating up the time so I set out to figure out 
a way to reduce the number of queries.

### Combining SQL Queries
I figured that the best way to combine the SQL queries was a two-pronged approach:
- Deal with more data at a time to reduce the number of queries.
- Combine necessary queries into one transaction with the database to reduce network traffic.

### A Rough Outline
As I began work on these improvements, I sketched out a basic outline for the process to help guide my work.

You can see this outline here: [Rough-In for Combining SQL Queries](https://github.com/jdsandifer/digital-paperwork/blob/master/RoughIn.php)

You can see I used a combination of some rough code and comments to specify the flow
and describe what needs to be added in each area. Breaking the programming into chunks 
like this not only helps me to focus on one thing at a time, but it also helps to ensure 
I properly breakup the work into functions and classes to help clarify what's being done 
in each section of code.
