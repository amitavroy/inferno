# Inferno
A Laravel based application which I use as a boiler plate for any project.

The theme used for the application is Bootstrap based AdminLTE theme which can be found <a href="https://almsaeedstudio.com/themes/AdminLTE/index2.html">here</a>.

## Installation
Git clone the repository and then run composer install to get the vendor packages.

    composer install

For development the application will also need the node packages so if you have npm or yarn the commands will be as follows

    yarn
    npm install

Once these things are done, you need to make a copy of the .env.example file and name it .env.
Once that is done, you need to setup your database connection, email settings etc.

Once done, finally you can run

    php artisan migrate --seed

This command will create all the tables and a user through which you can login as an Admin user.

    Username: reachme@amitavroy.com
    Password: password
    
Or you can also login through a normal authenticated user with limited set of permissions with the following credentials

    Username: jhon.doe@gmail.com
    Password: password

A lot of features are configuration based like what you want you app name to be, whether you want users to register for themselves.
For these, you need to check the settings.json inside storage folder.

This application also uses Real time capabilities using Redis, Socket.IO and Node. For this to happen, you need to also 
run 

    npm run realtime
    
What this is going to do is run a node based server on localhost port 8890 and the socket clients will listen to this.
And the Node application is going to use Socket and Redis to emit events.