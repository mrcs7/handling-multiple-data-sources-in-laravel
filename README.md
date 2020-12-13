## The Application

It's a simple demostration of handling multiple data providers in laravel along with docker, queues, design patterns.

* it has two endpoints for sending csv data and json.
* it fetchs csv file every 2 hours from sftp server.
* it has api to return product data.
* it exports data (every 4 hours) to a specific API.

## What is Done

- Three Endpoints to import data as json ,csv file and get product by identifier.
- Two Scheduled Commands Export Data Every 4 Hours and Import Data From My SFTP Server every 2 Hours. 
- Queued Job to import products.
- Some Unit And Feature Tests. 

## Running The App 
- run: docker-compose up  --build -d
- run: sudo docker exec -it {BuiltServiceName} composer install
- run: sudo docker exec -it {BuiltServiceName} php artisan migrate
- test :  sudo docker exec -it {BuiltServiceName} ./vendor/bin/phpunit 
- in new window, run: sudo docker exec -it {BuiltServiceName} php artisan queue:work
- in new window, run: sudo docker exec -it {BuiltServiceName} php artisan schedule:work
- The last two steps for simplicity and testing purposes but in real server we can use something like supervisor.
- the env file is provided and configured. 
- APIs Examples are found here https://documenter.getpostman.com/view/8779895/TVev5R4R

 ## App Structure
 - App\MrCs Contains Most Of The Services Classes,Interfaces,Abstracts.
 - App\Console\Commands Contains For Import Data From Sftp ANd Export Data To External Api.
 - App\Kernel Add Here the two Commands to run every 4 hours, 2 hours.
 - App\Http Added Controllers,Added Helper, Added Middleware,Resources,Requests.
 - App\Jobs Added Job
 - App\Models
 - config added some configurations.
 - test unit and feature tests
 
