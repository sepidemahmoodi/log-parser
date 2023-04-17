## About Project

This project built based on laravel framework and is about parse log file with spacific structure and store line by line in database.
there are some important point about this project :

- For parsing and storing data in database Observer design pattern has used. because when a chunk of data get parsed on job must be dispatched and i prefer
to use this design pattern for observing databaseWriter class untill chunk of data get parsed from microserviceLogParser class.
ofcourse i choose another design pattern for implementing this project and that is strategy pattern for choosing right class of logParsers that implements logParser interface and for choosing right logStorage when you have multiple logParsers and logStorages and you have to based on log file and its structure  choose suitable class of parsers and storages.
- We have MicroserviceLogFileParser and this is subject class of observer design pattern and parse method is the most important method on it.based on definition of problem we have milions lines of data in our log file so we should have good performance on our code,and it cuases using basic fopen and fget for reading files instead of using laravel File facades methods.we use read chunk of data then we call our observer which is responsiple dispatch a job for storing data in database.chunk of data has stored on database with bulk insertion.
- We use mysql database because we have search on data and it seems have good performance,ofcurse i added indices for increasing performance on columns that we will search on them and i used query builder for bulk insert and all filters instead of laravel elequent.
- We have Dockerfile of php and mysql config folders in docker folder that ignored in .gitignore file and docker-compose.yml file is exist for lunching project environment.
- I think we can use Repository pattern for log and add count query in it then inject to controller and use it in count api,but unfortunately i cant understand correctly this design pattern so i decided to didnt use that. 


## Laravel .env config for database connection :
`DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=bugloos
DB_USERNAME=root
DB_PASSWORD=mypass`

## Installation : 
 - first of all clone the project : `git clone git@github.com:sepidemahmoodi/log-parser.git`
 - in root of project run : docker compose up -d
 
## Console Command :
 - you should use php artisan log:sotre command and enter logFile path, in this project logFile path is `/var/www/html/logs.txt`
 
## Api description : 
 - Route of Api found with this url :(localhost:8000/public/api/logs/count) then you can add query params like service_name, http_status_code, start_date and end_date for filtering the query result.
