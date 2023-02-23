# Home Task Implementation

## Prerequisites

-   Docker and Docker Compose installed

## Installation

1.  Clone this repository.
2.  Copy `.env.example` to `.env`.
3.  In the root directory, run the command `make install`.
4.  Run the command `make migrate` to create the necessary database tables.
    -   **Note:** After Docker is shut down, you will need to run this command again. Alternatively, you can set up database persistence via a volume.
5.  Go to the Gotify UI at `http://localhost:64002/` (using credentials `admin:admin`) and set up an application token.
6.  Replace the `X_GOTIFY_KEY` value in the `.env` file with the new token you created.
7.  Make a request to `POST http://localhost:64000/verification` to create a verification. (Use the request body as described in the Home Task documentation.)
8.  Check Mailhog at `http://localhost:64001/` and Gotify for the verification code.
9.  Make a request to `PUT http://localhost:64000/verification/{uuid}/confirm` to confirm the verification. (Use the request body as described in the Home Task documentation.)

## Testing

**TODO**

## Additional Resources

-   [Symfony DDD Example](https://github.com/salletti/symfony-ddd-example)
-   [TaskManager](https://github.com/k0t9i/TaskManager)
-   [Absolute Beginner's Guide to DDD with Symfony](https://github.com/nealio82/absolute-beginners-guide-to-ddd-with-symfony)
-   [CodelyTV PHP DDD Example](https://github.com/CodelyTV/php-ddd-example)
-   [DDD and Symfony Tutorial](https://www.youtube.com/watch?v=pfMGgd_NDPc&ab_channel=GrUSP)
-   A lot of articles on DDD and Symfony can be found via Google.
-   _Domain-Driven Design: Tackling Complexity in the Heart of Software_ by Eric Evans (recommended reading)enter code here