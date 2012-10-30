#Eventual

* Version: 1.0
* [Website](http://estudijas.lu.lv/course/view.php?id=1348)

## Description

Eventual is an example event management system developed
during "Web Technologies II" course at the University of Latvia.

## Installation

The application is accessed at http://localhost/sites/eventual 
on the development machine.

If you decide to change the location, take care to alter the 
.htaccess file (`RewriteBase` parameter).

## What is where

  - CRUD model implementation can be found at APPPATH/classes/model/crudevent.php 
    This is used in APPPATH/classes/controller/event.php, `action_crudlist()` and `action_crudupdate()` methods
  - Several files demonstrating ORM models can be found at APPPATH/classes/model/orm/
    This shows the structure of "event" happening at a "location" and having several "agenda" items.
    Detailed list of events is output to the screen in APPPATH/classes/controller/event.php method `action_ormlist()`.
    It employs the view APPPATH/views/event/ormlist.php
