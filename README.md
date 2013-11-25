#Eventual

* Version: 1.0
* [Website](http://estudijas.lu.lv/course/view.php?id=1348)

## Description

Eventual is an example event management system developed
during "Web Technologies II" course at the University of Latvia.

## Installation

The application is accessed at http://www.eventual.org
on the development machine (a [hosts file entry](http://www.howtogeek.com/howto/27350/beginner-geek-how-to-edit-your-hosts-file/) 127.0.0.1 = www.eventual.org)

If you decide to change the location, take care to alter the 
.htaccess file (`RewriteBase` parameter).

The system uses "fuel_dev" database. 
The default configuration expects the following database configuration 
(change these settings in APPPATH/config/development/db.php if needed.):

  - server : localhost
  - database : fuel_dev
  - user : fuel_dev
  - password : fuel_dev

The installation procedure expects that the database exists and that 
it is empty (no tables created).

After you put all the files in web root, execute `php oil refine migrate`. 
This will create the needed database tables and add sample data to them.

## What is where

  - CRUD model implementation can be found at APPPATH/classes/model/crudevent.php 
    This is used in APPPATH/classes/controller/event.php, `action_crudlist()` and `action_crudupdate()` methods
  - Several files demonstrating ORM models can be found at APPPATH/classes/model/orm/
    This shows the structure of "event" happening at a "location" and having several "agenda" items.
    Detailed list of events is output to the screen in APPPATH/classes/controller/event.php method `action_ormlist()`.
    It employs the view APPPATH/views/event/ormlist.php

## Setting it up in NetBeans

  - Download the code from GitHub. If you don't have a GIT client, 
    simply take the .zip version: [https://github.com/naivists/TTII_2012/archive/master.zip]
  - Unzip it somewhere in your computer. This place does not have to be in the "web root"of your 
    web server. On a Windows computer, you could pick c:\eventual\.
  - Open up NetBeans IDE. In File menu, choose "Open project". Point to the 
    directory you have chosen.

