# Backend API Technical Challenge

We'd like to get to know you better, so we've prepared a technical task that will tell us more about you. You can find more information about it below.
If you have any questions or you don't fully understand something, do not hesitate to ask us for clarification. Also, we are always looking to improve our technical test so feel free to send us any feedback on the exercise.

## Scenario

Gousto’s technical infrastructure includes an API Gateway that offers a number of operations related to recipes. The recipes are very detailed, containing information such as cuisine, customer ratings & comments, stock levels and diet types.
Your task is to design, develop and deliver to us your version of a set of recipe operations. The solution should meet our functional and nonfunctional requirements below:

**GET** **_/api/v1/recipes/{ID}_**

As an API client I want to see a recipe's details

When​ I fetch a recipe by ID

Then​ I can see recipe fields

**GET** **_/api/v1/recipes/_**

As an API client I want to see a paginated list of recipes by cuisine

When​ I fetch a recipe by cuisine

Then​ I can see a list of recipes

And​ the list is split into paginated results with 10 recipes per page

And​ each recipe has to contain only the fields ID, title and description. 

As an API client I want to update one or more recipe's fields

**PATCH** **_/api/v1/recipes/_**

Given​ that I am an API client

When​ I update one or more recipes fields 

Then​ I can see the updated recipe fields

## Setup

Install dependency

```composer install```  

Run Server 

```php bin/console server:start```

```php bin/console server:run```

Run test

```./vendor/bin/simple-phpunit || bin/phpunit```

## Possible improvements

Would have style the element better and create links between page. Would have also liked to have a makefile as well.
