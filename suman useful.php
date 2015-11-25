

For git 
-------



=> For git pull

	1. git pull origin master. ( Paste to the terminal )
	2. Give password of your account.

=> For git push

	1. git push origin master. ( Paste to the terminal )
	2. Give password of your account.

=> Check branch in git

	1. git branch ( Paste to the terminal )

=> For change branch

	1. git checkout <existing-branch>
	=> for leave that branch write this command.
	=> and let say branch name is "suman"
	=> Command is - git checkout suman


	2. git checkout -b <new-branch>
	=> for entry to a new branch write this command.
	=> and let say branch name is "banty"
	=> Command is - git checkout -b banty

=> For git merge

	1. git merge <branch>
	=> let say branch name "suman"
	=> Command is - git merge suman

=> For check git status

	1. git status ( Paste to the terminal )


=> For Commit with message

	1. git commit -am 'Change password functionality ,Migrate for category table and  Create category modules'
	=> git commit -am 'message'

=> For add your changes

	1. git add -A
	=>A for all




Step for git commit
--------------------

	1. Check your branch.

	2. Check git status.

	3. Add new file or changes file to git.(git add -A)

	4. Commit with massage

	5. Change to branch master

	6. Merge branch changes.
		-> git merge suman

		












For virtual host
----------------

1. sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/talent.local.conf


2. sudo nano /etc/apache2/sites-available/talent.local.conf


3. 	<VirtualHost *:80>
	    ServerAdmin webmaster@localhost
	    DocumentRoot /var/www/html/talent.local/
			ServerName talent.local
			ServerAlias talent.local
	    ErrorLog ${APACHE_LOG_DIR}/error.log
	    CustomLog ${APACHE_LOG_DIR}/access.log combined

	    <Directory "/var/www/html/flokstr/frontend/web/">
           # use mod_rewrite for pretty URL support
           RewriteEngine on
           # If a directory or a file exists, use the request directly
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           # Otherwise forward the request to index.php
           RewriteRule . index.php

           # use index.php as index file
           DirectoryIndex index.php

           # ...other settings...
       </Directory>

	</VirtualHost>


4. sudo a2ensite talent.local.conf




*** Save in nano => ctrl + o

restart apache2 => sudo service apache2 restart



Migration in yii database
-------------------------


	1. Create new table migration 

			=> php yii migrate/create create_news_table

	2. Write code on console=>Migration=>New_create_migration_file

	3. For apply this migrate

			=> php yii migrate



Query about website.

1. About the background image or background video before login page.
	(From where the images and videos fetch)

2. About the background image or background video after login page.
	(From where the images and videos fetch)

3. Query about flokstr Bookmarklet widget (From round 2 feedback, Slider 3, Point 4)

4. About category (From where fetch category, And be specific about Interest and Category )
	( Query about slider number 7 for steps ) Slider number 9.

5. Conformation - Send email invitation for non registered users.

6. Slider Number 10 - For fetch friend list from phone book.

7. Query about slider number 12 (Total flow)





Dear Mam,
I would like to inform you that I have an urgent schedule client call tonight, 27.10.15.For that I have to leave office at 6:30PM.
So requesting you to kindly look into this matter.


Dear Mam,
I would like to inform you that I have done work from home last friday, 23.10.15 by taking permission of both Indranil da and Arghya da.
So requesting you to kindly look into this matter.

Dear Mam,
I would like to inform you that I will change my office timing shift only for tomorow 27.10.15 for laxmi puja.
So requesting you to kindly look into this matter.


Hello yoli,
A very good morning to you.Hope you doing well.

Ok, That's fine.
I would like to ask you 1 query regarding the API. We are discussing about the API with our team members.We must say that all API are very good.
You have send more then one API for specific one task.Like A,B,C three of them are present for payment getaway.
My query to you is do you need all of them, or only the best one among them is  preferred.

Ok Yoli, Thank you for your co-operation.Another question I have,If you don't mind.
I would like to ask you about the background image or video.I have noticed a background image or video in first landing page.
My question is that we dynamically change the image - right.
what is the image based on? Like users interest or what.
Ok. If it is based on users interest, then before loged in how we will get the users interest.?

I have not understand Slider 3, Point 4, which is - "In the design comp show the search box with prepopulated search as it would if the user had come via the Flok Bookmarklet widget. Or it should say “Search music event, artist or flok ”"
If you please tell me about this thing, we will be very greatfull to you.

Yes all of these are possible from our end. We can do all of them. But we need time for that. for which i indronil talk to you.

Thank you yoli. Have a nice day.

Yes, we are working on admin panel. We are already done with the user management system. Where admin can manage all registered member. Admin can create a member account, edit and delete account.
Same admin can manage category management , insert,update delete.
Another management system is there, that is global settings.which is a settings for active or deactivate services,like newsletter.


Hi yoli, I am just asking about the google map, Like where you want to use this particular API in this project.

Ok, that's make sence.

And about the Deal API where you want to use that API.


1. In which section we will be using google map API in this project.

2. In which section we will be using Deals API in this project.In deal and activity API Living Socialonly provides only deals.

3. For the Restaurant Booking API when you are booking a restaurant, at that time the website is redirecting to a new link.Is that ok with yoli?

4. What do you want from Trip Advisor API? But Trip Advisor API will not provide you reviews details,
 It will provide rating, ranking and an url where you can give a review, and view all other reviews.


we are using 1 api from where we are getting reviews, and  another api from where we can do hotel booking.
now my question is how can we connect these two APIs as both of them having different ID.

