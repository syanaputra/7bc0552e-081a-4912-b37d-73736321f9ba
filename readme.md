# UUID

ACER coding challenge

## How to use

### Running app
Run the following command:
```
docker-compose run app
```

Once you have run above, you will see the following:

```
Please enter the following
Student ID: <student-number>
Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback): <report-number-by-user>
```

The common student numbers are: `student1`, `student2`, `student3`

### Running PHPUnit Test
Run the following command:
```
docker-compose run test
```

## Changing the data

You can change / update the data by modifying the `app/data/*.json` files.

## Maintainer
Stephanus Yanaputra - stephanus.yanaputra@gmail.com