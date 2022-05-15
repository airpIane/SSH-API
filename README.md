# SSH-API
1. Install Ubuntu 18
2. apt install apache2 php php-fpm php-ssh2 -y
3. service apache2 restart

When Using:
Credentials on the api must be changed to the ones on your own server.
Input your server ip in the fourth line or just use localhost.
When adding a new method input , "METHODNAME" after stop.
Add your API key to the spot where its meant to be located to protect it.
Upload your file to /var/www/html

Example of API Link: http://SUSPECTSERVERIP/api.php?key=superkey&host=[host]&port=[port]&time=[time]&method=[method]
