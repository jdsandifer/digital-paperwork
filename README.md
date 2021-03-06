# Event Digital Paperwork App
A React app I pioneered and helped implement at work to increase department efficiency and decrease paper usage.

### Start of the Project
We had used a paperwork-based system for managing the setup and tear-down of equipment in my department at work. 
This made it easy for vital information to get misplaced and created difficulties with keeping information up to date 
and centralized for reference.

One of my supervisors got the idea to move to a digital system and created software to read all of the event data from the 
system currently in use, organize it all and store it in a custom database, and then access it from tablets. 
This allowed people on opposite sides of the building to communicate about what was being setup or struck as they 
did those tasks.

### Impetus for Change
While this system was a huge improvement, it had some room for improvement before it could be effectively used full-time. 
Because of the interdependent way that the server and frontend were tied together, page loads were unbearably slow on larger events - 
even creating lockups on the largest events because of all of the data passing back and forth.

### The Solution

I was consulted to see what could be done to improve the situation. I suggested moving toward an API system where the front-end queried 
the backend for data, received all the data for each event at one time, and then controlled the display of that data. 
I also suggested using React on the frontend to help force a component approach to the front-end development and help 
speed up the rendering of the front-end.

### Aftermath
My suggestions were accepted and I helped with the implementation - making most of the front-end changes myself. Page loads for the software improved dramatically. Even the largest events were 
loading in reasonable time frames and the user interface was more responsive.

### Continual Improvement
Even after the initial success of my solution, I found additional ways to improve the software. Using PureComponent, 
I was able to make sure components that didn't have changes in data weren't re-rendering with each new cycle. 
With that and other optimizations, the UI it is now very responsive.

In addition, I continued to contribute to the system by helping to improve the back end next: [Back End Improvements](https://github.com/jdsandifer/digital-paperwork/blob/master/Backend.md).
