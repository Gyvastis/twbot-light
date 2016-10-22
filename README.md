##Crontab example
```
*/10 * * * * wget http://localhost/routes/cron.php/fetch-followers/1000 > /dev/null 2>&1
* * * * * wget http://localhost/routes/cron.php/fetch-followers-details/100 > /dev/null 2>&1
* * * * * wget http://localhost/routes/cron.php/follow > /dev/null 2>&1
* * * * * wget http://localhost/routes/cron.php/post > /dev/null 2>&1
* * * * * wget http://localhost/routes/cron.php/unfriend > /dev/null 2>&1
```