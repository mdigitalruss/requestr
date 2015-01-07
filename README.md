# Requestr v0.2.0
A really simple PHP request/inclusion system. Be aware that it's still in development and features are subject to change, no warranty is given or implied.

## What can you do with it?
This class handles grabbing values from querystrings and loading the appropriate file and class and then executes the desired method.

## How do I even..?
Well, let's walk through it step by step..

### Querystring
In this example, our querystring looks like this:

index.php?action=articles&subaction=news

### Initialise the request router class
We want to use "action" and "subaction" GET variables, so we specify this as the first and second parameters when we create the requestr class.

```PHP
$request_router = new helical\requestr\router('action','subaction','pages');
```

The first two parameters define the querystring attributes for the class and method we want to load.

The third parameter is the folder where our page scripts will be kept.

### Create the page script
Our page is called articles, so in our /pages folder, add a subfolder called "articles", and inside that folder create "articles.php".

You should now have /pages/articles/articles.php.

Hint: It's also worth creating /pages/homepage/homepage.php too, since this is the 'default' script which will be loaded if there is no querystring provided.

### Create the class
Inside "articles.php", our script will be looking for "articles" class within the helical\requestr\page namespace, so let's make it:

```PHP
namespace helical\requestr\page;

class articles
{
	public function _default(){}
}
```

As you can see, we also created the method "_default()". This method will be called when no subaction GET variable is specified.

Hint: Requestr page classes must be defined within the helical\requestr\page namespace to avoid name collisions.

### Create the method
Simply create the method for news, inside the articles class:

```PHP
public function news()
{
	echo "And here's the 10 o'clock news..";
}
```

Hint: Make sure your method is Public. The request router will not run private methods. This can be useful for helper methods within your page class - you can stop them from being run as a request handler by making them private.

### And run
We just need to tell requestr to run

```PHP
 if($request_router->statusCode() != 200 || !$request_router->run()){
    echo $request_router->statusMessage(); // You could put a 'error 404' template here if you want.
}
```

This code blocks checks the class loaded correctly when we initialised the request router, and runs the page class. If the router cannot run the page class, it outputs the status message. This could be worked into an error 404 template if you want.

### Also...
You can also specify attributes within the page class by adding a public variable called $requestr_attributes (typically you would use an array). These are accessible via requestr::getAttributes().

For a working example, see "examples/example.php".

Enjoy!