# SkillQuest App Sign In Demo

Beta version prototype for the SkillQuest App's sign in functionality.

## Description

This project is a part in an assignment for our groups' HCI (Human Computer Interaction) module. As per the assignment brief, this part of the task was to create a beta version prototype for one key function of the app.

This demo serves as a prototype and interactive visualization of the app proposed.

The project uses the following languages:

* HTML
* CSS
* JavaScript
* PHP
* SQL

## Installation/Setup
### Important

This installation covers Windows users using XAMPP only, as that is what I have tested it on. although most other web server environments could probably be used, results may differ in connecting to phpmyadmin.

To solve this, change the values of the `$host`, `$user`, and `$pass` variables in `db.php` with those needed in your respective web server environment, should you use one other than XAMPP.

### Dependencies

* Any database server running on localhost:3306
* PHP 7.4+ with mysqli extension enabled
* XAMPP, or any Apache/Web Server
* Google OAuth Credentials

### Environment Variables

In order to use the Google's Sign-In API, you will need to add the following environment variables to a `tokens.env` file.

`GOOGLE_CLIENT_ID`

`GOOGLE_CLIENT_SECRET`

To get the client ID and secret, head to [console.cloud.google.com](console.cloud.google.com), and create a new Client in the OAuth Consent Screen tab, or if you're still confused, read their OAuth 2.0 documentation [here](https://developers.google.com/identity/protocols/oauth2).

After putting in the environment variables and client ID/Secret, the file should look like this:  
`tokens.env`
```env
GOOGLE_CLIENT_ID=your_client_ID_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
```

### FIlename modifications

The file needs to be named as such, as the loader looks for a file named `"tokens.env"`. You can however, modify `env.php` to accept your .env filename in line 2, replacing `"tokens.env"` with your .env filename.

### Installing

* Download the latest release from the repository
* Extract the files to your XAMPP htdocs folder  
```C: > xampp > htdocs```

* Create/paste the `token.env` file inside the project's root directory

### Database Setup
* Start XAMPP, enable Apache and MySQL, and go to `http://localhost/phpmyadmin/`
* Navigate over to the `SQL` tab, 
* Paste the contents of the `dbinit.sql` file into the SQL console and click `Go` to initialize the database.

### Executing project

* Start XAMPP and enable Apache and MySQL
* Open your browser and navigate to `http://localhost/SkillQuest-App-Demo`

### Common Errors
#### The webapp could not connect to the database.  
A: Check the variables in the `db.php` file, and ensure the credentials to connect to your database are correct (might differ with each web server environment/DBMS).

#### XAMPP could not launch MySQL since port 3306 is taken.
A: Mostly caused by other SQL servers previously downloaded and initialised, either delete the previous SQL servers in your device, or change the port in XAMPP's `ini.my` file. Look up a youtube video or other guide for further help.

#### Google could not authorize to use their API. 
A: Check to make sure your `GOOGLE-CLIENT_ID` and `CLIENT_SECRET` variables are set correctly in the `token.env` file.

#### I'm using XAMPP or phpmyadmin, how can I connect to my database?
A: As mentioned in the "Important" Section above, I have no idea since I built this with XAMPP and phpmyadmin in mind, so refer to online guides and youtube tutorials.


### Contact
Should there be any errors with the build, or have any questions, feel free to contact me at:
`farrelirfandri@gmail.com`  

or if you are one of my lecturers/in my organisation, contact me at:   
`0364649@sd.taylors.edu.my`
## License

This project is licensed under the MIT License - see the LICENSE.md file for details

## Acknowledgments

* [Google Sign-In Manager Library](https://codewithmark.com/sign-with-google)
* [Google Sign-In API](https://developers.google.com/identity/sign-in/web/sign-in)
* [ReadMe Template](https://gist.github.com/DomPizzie/7a5ff55ffa9081f2de27c315f5018afc)
