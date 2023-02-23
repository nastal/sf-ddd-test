#Home task implementation

1. clone this repository
2. ensure that you have installed docker and docker-compose
3. copy .env.example to .env
4. run the command `make install`
5. run the command `make migrate` (note, after docker is down you need to run this command again. Or take care of persistence of the database via volume)
6. go to gotify http://localhost:64002/ (admin:admin) and set up Application token
7. replace token in .env file X_GOTIFY_KEY=new_token
8. make request to POST http://localhost:64000/verification to create verification (use body as describes in hometask docs)
9. check mailhog (http://localhost:64001/) and gotify for the code
10. make request to PUT http://localhost:64000/verification/{uuid}/confirm to confirm code (use body as describes in hometask docs)

//todo tests

[Learning curve on DDD and Symfony:
- https://github.com/salletti/symfony-ddd-example
- https://github.com/k0t9i/TaskManager
- https://github.com/nealio82/absolute-beginners-guide-to-ddd-with-symfony
- https://github.com/CodelyTV/php-ddd-example
- https://www.youtube.com/watch?v=pfMGgd_NDPc&ab_channel=GrUSP
- A lot of articles on DDD and Symfony consumed using Google.

- Eric Evans - Domain Driven Design... Sorry, no)) Have not read it yet. But I will.