# Memogen Notes and Todo-list Application - Backend

This is the backend source files with the APIs needed for my first CRUD notes and todo list manager application.

## Table of contents

- [Overview](#overview)
  - [The challenge](#the-challenge)
  - [Screenshot](#screenshot)
  - [Links](#links)
- [How to use](#how-to-use)
- [My process](#my-process)
  - [Built with](#built-with)
  - [](#what-i-learned)
  - [Continued development](#continued-development)
  - [Useful resources](#useful-resources)
- [Author](#author)
- [Acknowledgments](#acknowledgments)

**Note: Delete this note and update the table of contents based on what sections you keep.**

## Overview

### The challenge:
- Perform the adding of user/s to SQL database with limited privileges (own choice) via web-based interface.
- Develop a web-based login page for the authentication of users before the system's access.
- Create a webpage that will display the user's assigned privileges every after successful entry to the system.

### APIs should be able to:
- Get the tasks and notes of the user logged in
- Post new task and memo to the database under the user's id
- Update tasks' and memos' details by their ids
- Get tasks and notes by inputted keywords

### Screenshot

![](./screenshot.jpg)

Add a screenshot of your solution. The easiest way to do this is to use Firefox to view your project, right-click the page and select "Take a Screenshot". You can choose either a full-height screenshot or a cropped one based on how long the page is. If it's very long, it might be best to crop it.

Alternatively, you can use a tool like [FireShot](https://getfireshot.com/) to take the screenshot. FireShot has a free option, so you don't need to purchase it. 

Then crop/optimize/edit your image however you like, add it to your project, and update the file path in the image above.

### Links

**Note: I will be deploying this entire app in the future. I have a limited time to deploy it on heroku which I have not used before since the deadline of this school project is later this day @ 12:00 am 2021-11-28. To use it for now, follow the instructions in the How-to-use section.**
<!--
- Solution URL: [Add solution URL here](https://your-solution-url.com)
- Live Site URL: [Add live site URL here](https://your-live-site-url.com)
-->

## How to use

To clone and run this application, you'll need [Git](https://git-scm.com) and [Node.js](https://nodejs.org/en/download/) (which comes with [npm](http://npmjs.com)) installed on your computer. 

 1. clone this repo and put it in the htdocs under your xampp folder
 2. create a new database and name it notes-app
 3. create 3 tables with these properties
 4. under the users table create a new user named Visitor with an id number of 8 with this sql command
```
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES (8, 'Visitor', 'test@gmail.com', '$2y$10$1KqJrmpixqLY36gIyllJfuQFWreJbVw7ZYiTtXcuXHQ1WX7qILZcS')
```
 5. run the apache and mysql in your xampp control panel
 
 6. run the apache and mysql in your xampp control panel


### APIs should be able to:
- Get the tasks and notes of the user logged in
- Post new task and memo to the database under the user's id
- Update tasks' and memos' details by their ids
- Get tasks and notes by inputted keywords


## My process

### Built with

- [PHP](https://www.php.net/) - For connecting the backend to the frontend
- [MySQL](https://www.mysql.com/) - Database service
- [Apache](https://httpd.apache.org/) - For HTTP server
- [JWT](https://jwt.io/) - For token authentication

### What I learned

Use this section to recap over some of your major learnings while working through this project. Writing these out and providing code samples of areas you want to highlight is a great way to reinforce your own knowledge.

To see how you can add code snippets, see below:

```html
<h1>Some HTML code I'm proud of</h1>
```
```css
.proud-of-this-css {
  color: papayawhip;
}
```
```js
const proudOfThisFunc = () => {
  console.log('🎉')
}
```

If you want more help with writing markdown, we'd recommend checking out [The Markdown Guide](https://www.markdownguide.org/) to learn more.

**Note: Delete this note and the content within this section and replace with your own learnings.**

### Continued development

Use this section to outline areas that you want to continue focusing on in future projects. These could be concepts you're still not completely comfortable with or techniques you found useful that you want to refine and perfect.

**Note: Delete this note and the content within this section and replace with your own plans for continued development.**

### Useful resources

- [Example resource 1](https://www.example.com) - This helped me for XYZ reason. I really liked this pattern and will use it going forward.
- [Example resource 2](https://www.example.com) - This is an amazing article which helped me finally understand XYZ. I'd recommend it to anyone still learning this concept.

**Note: Delete this note and replace the list above with resources that helped you during the challenge. These could come in handy for anyone viewing your solution or for yourself when you look back on this project in the future.**

## Author

- Website - [Add your name here](https://www.your-site.com)
- Frontend Mentor - [@yourusername](https://www.frontendmentor.io/profile/yourusername)
- Twitter - [@yourusername](https://www.twitter.com/yourusername)

**Note: Delete this note and add/remove/edit lines above based on what links you'd like to share.**

## Acknowledgments

This is where you can give a hat tip to anyone who helped you out on this project. Perhaps you worked in a team or got some inspiration from someone else's solution. This is the perfect place to give them some credit.

**Note: Delete this note and edit this section's content as necessary. If you completed this challenge by yourself, feel free to delete this section entirely.**
