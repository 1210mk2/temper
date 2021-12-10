# Temper challenge
Solution is using composer.

There will be 2 docker containers arranged: nginx, fpm.

## Prerequisites

1) you should have docker with docker-compose installed
2) 500 Mb of free space

download, build and run containers by
```
docker-compose up -d --build
```


## Run task

by running index.html in browser. And pushing "Get data" button there
```
http://localhost:8098/index.html
```

## Solution presumptions

1) The data placed in input files does not intersect. That means there should be no rows with same user_id field
2) Due to time limit and high load on current project no tests were made
3) 


