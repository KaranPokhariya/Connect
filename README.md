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
8. Create another table 'posts' with attributes:
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
9. Create a table 'likes' with attributes:
    - id (auto increment)
    - type
    - url_id
    - liked_by
    - following
10. Run your favourite browser and at the address bar, replace ../<folder_name>/signup.php with localhost/<folder_name>/signup.php
11. Create your account->Login-> Enjoy

# Screenshots
![Screenshot (112)](https://user-images.githubusercontent.com/36101958/100543926-b3446380-3278-11eb-98a2-ceb7a0395a87.png)

![Screenshot (113)](https://user-images.githubusercontent.com/36101958/100543961-c5be9d00-3278-11eb-982c-4d5151d6b0a4.png)

![Screenshot (114)](https://user-images.githubusercontent.com/36101958/100543971-ca835100-3278-11eb-8fd6-94a9342c994d.png)

![Screenshot (115)](https://user-images.githubusercontent.com/36101958/100543976-cfe09b80-3278-11eb-84b8-0e4d10a80f7d.png)
