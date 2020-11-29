# Connect
This project is a simple social networking web application to connect and build social relationships with friends, family, colleagues, or clients.

# Scope
## Features:
  1. Sign up
  2. Log in
  3. Update profile and cover image
  4. Create a post
  5. Like/Comment on a post
  6. Edit/Delete a post
  7. Search for someone
  8. Follow someone
  9. Update basic credentials
  10. Gallery

## To Do:
  1. Messaging medium
  2. Network security

# Installation
- Text editor (Visual Studio Code, Sublime Text, Notepad++, etc)
- XAMPP

# Technologies
- HTML
- CSS
- PHP

# Illustrations
1. Install XAMPP
2. Download all the files files from the repository
3. Paste all the files to ../xampp/htdocs/<folder_name>
4. Run XAMPP Control Panel and start Apache and MySQL module
5. Open a browser and search for localhost/phpmyadmin/
6. Create a new database with the name connect_db
7. Create a table 'users' with attributes:
    - id (auto increment)
    - userid
    - first_name
    - last_name
    - gender
    - email
    - password
    - url_address
    - date
    - profile_image
    - cover_image
    - likes
    - about
  Create another table 'posts' with attributes:
    - id (auto increment)
    - postid
    - userid
    - post
    - parent
    - image
    - has_image
    - comments
    - likes
    - date
    - is_profile_image
    - is_cover_image
  Create a table 'likes' with attributes:
    - id (auto increment)
    - type
    - url_id
    - liked_by
    - following
8. Run your favourite browser and at the address bar, replace ../<folder_name>/signup.php with localhost/<folder_name>/signup.php
9. Create your account->Login-> Enjoy
