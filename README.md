# Requestr v0.1
A really simple PHP request/inclusion system. Be aware that it's still in development and features are subject to change, no warranty is given or implied.

## What can you do with it?
This class handles grabbing values from querystrings and loading the appropriate file, class and then executes the desired method.

## How do I even..?
Well, let's walk through it step by step..

### Querystring
In this example, our querystring looks like this:

index.php?action=home&subaction=news

### Initialise the class
We want to use "action" and "subaction" GET variables, so we specify this as the first and second parameters when we create the requestr class.

```PHP
$example_page = new requestr('action','subaction','pages');
```

Our PHP file and class must be prefixed with "action_" since that's what we chose in requestr. Furthermore, our methods in the "action_" classes must be prefixed with "subaction_". The third parameter is the folder where our "action_" files will be kept.

### Create the pages
Our page is called home, so in our /pages folder, add "action_home.php". It's also worth adding "action_default.php" too, since this is loaded when no "action" GET variable is specified.

### Create the class
Inside "action_home.php", our script will be looking for "action_home" class, so let's make it:

```PHP
class action_home
{
	public function subaction_default()
	{
	}
}
```

As you can see, we also created the method "subaction_default()". This method will be called when no subaction GET variable is specified.

### Create the method
Simply create the method for news, with the subaction prefix, inside the action_home class:

```PHP
public function subaction_news()
{
	echo "And here's the 10 o'clock news..";
}
```

### And finally..
We just need to tell requestr to GO!

```PHP
$example_page->go();
```

### Also...
You can also specify attributes within the page class by adding a public variable called $requestr_attributes (typically you would use an array). These are accessible via requestr::getAttributes().

For a working example, see "examples/example.php".