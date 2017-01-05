# InSided Assessment


## Introduction

The idea behind the assessment was to be able to develop something that really works 
and deploy it into a Cloud Server so everybody can easily see it.

Problem in this case is that is not the typical assessment in which you deploy some
object oriented code and some tests for it. In this case it was necessary to build
all the environment and make it work.

Because of that I had two options.

- Use an open source framework like Symfony which gives me all the environment
working and focus on my business logic;

- Go into problems and develop a complete micro framework to be able to show also
my develop skills and my architectural mindset.

Of course, I choose number two, so this assessment has taken me "a little more"
than expected.


## Architecture

I decided to develop a micro framework similar to Symfony 2 bundles structure
because I think is one of the most efficient ones.

Please, pay attention to project structure because I think is one of project
biggest points.

My framework implements a FrontController class that plays the router role. It 
also injects request results into a main layout.

Like Symfony, I put the index.php file one level into root dir to avoid direct
access to php resources.

My project has two bootstrap files, one for the execution environment and other
one for the testing part.

I decided to use MySQL as database for the execution stack and SQLite "In memory"
to accelerate test execution.
For the automatic tests I'm also using DoctrineFixtureBundle to load fixtures.


## Testing

Because of the quite big quantity of code developed I decided try to focus on
generate a nice sample of testing suite more then get high coverage percent.

I coded tests for the class PostManager and I develop a Mock for FileManager
like if it was an external dependency (despite I know is not a best practice
I thought it would be a complete example).


## Assesment scope

Because of my choice I have dedicated a lot more time than expected and I wasn't
be able to finish all "extra points" features.

This is the assesment points checklist:

YES - Initially only the Top bar and the Reply box are visible.

YES - Successfully uploading an image creates a post.

YES - Empty title is allowed.

YES - The list of posts grows downward with the most recent post at the top.

YES - Support the JPEG image format only.

YES - Bonus points: Support PNG and (animated) GIF as well.

YES - Image size: upto 1920x1080, upto 2 MB. Bonus points: image size upto 20 MB.

YES - #posts increments with each new post.

NO  - #views increments with each view.
    (having some problems with htaccess and I would need some more time to fix it)

YES - Performance: The post must be visible within 2 seconds, and all the images
must be complete loading within 5 seconds on a 10 Mbps Internet connection.

NO  - Clicking the Export button produces a CSV file with a header row and two
columns: (image) Title and Filename.

NO  - Bonus points: Make it possible to export the Excel format as well.

NO  - Bonus points: clicking the Export button produces a ZIP file with all images
and the CSV file mentioned above.

NO  - Bonus points: The #posts and #views should update every 15 seconds without reloading the
page. (I prefered focus on backend features because of the lack of time)

YES - Bonus points: deploy the app on a server and send us the URL.
YES - Bonus points: use a cloud provider.

YES - Bonus points: Scaling the app
Our little app is becoming a success. During the busy times we have upto 10 posts
and 500 views per minute. We expect 10x growth in the next 6 months.
How would you (re)design the app to handle that? Sketch a diagram of the (cloud)
infrastructure.

NO  - Bonus points: The API

We have just signed up a big enterprise customer. They want to integrate the ImageThread app with
their site. Design an API to be able to: create posts, retrieve individual posts, perform a bulk export.
