# This is a website used to navigate different recipes in terms of difficulty, type of meal, and ingredients. A cookbook made with PHP and SQL database.

## How do I run it locally? these steps are for MaciOs machines as this is what was used to create the website:
1. download MAMP and the project into the computer
2. move all of the project files into your MAMP htdocs folder
3. open MAMP and hit the start now button
4. hit the webstart file and find phpmyadmin category
5. create a new database titled cookbook_db, then take the schema.sql file and import it under the import category
6. create a config file and enter your credentials. ensure the config file is not publicly available
7. open any web browser of your choice and type in: http://localhost/your-folder-name/alpha/alpha.php (or http://localhost:8889/your-folder-name/alpha/alpha.php depending on your MAMP port settings)

## AI USAGE
- used Gemini to set up PHP and figure out the echo/message tool

- used gemini to figure out how to put the code together to do what i want it do, and also to explain it to me so i had an understanding of what each thing did so i can know when or how to use them when writing my own code

- used gemini to figure out how to properly set up the week3 file and make it look a little nicer, as well as including any errors when the recipes fail to show up to indicate to the user (or myself) that there ARE recipes to look at, but there is something wrong right now

- used gemini to figure out how to import the schema file into the database so that the recipes show up

- used gemini to set up a better flexbox layout for the recipes and the pictures

- used gemini to figure out which data file (used recipes) to import into SQL rather than just importing everything all at once

- used gemini to figure out grid and how to use the php commands properly to create search and add new recipe bars