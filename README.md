## Installation

I assume you have `docker-compose` installed and either **docker-engine** running locally (Linux) or have **docker-machine** (installed via [docker-toolbox](https://www.docker.com/products/docker-toolbox) on OSX, Windows)
configured on the computer you use. _NOTE: if you use docker-machine (deprecated project so recommend not to) you may need to use the docker-machine IP address instead of `localhost:8035` URLs mentioned below_

1. Retrieve git project

    ```bash
    $ git clone git@github.com:ibrohim238/comics.git
    ```

2. Change directory to the `docker-laravel` (`cd docker-laravel`)

3. Symlink your Laravel/Lumen project into app folder (`ln -s <absolute-path-of-laravel-project> app`)

4. Build and start containers in detached mode.

    ```bash
    $ docker-compose up -d
    ```

5. Prepare Laravel/Lumen app
    1. Update app/.env (adapt hosts according to previous results)

        ```ini
        # Docker database configuration
        DB_CONNECTION=mysql
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=homestead
        DB_USERNAME=homestead
        DB_PASSWORD=secret

6. Enjoy 😀

## Use

* Docker php container

  `docker-compose exec app bash`
