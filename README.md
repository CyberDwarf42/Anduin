# Anduin

This project is an inventory management software mixed with a web-based point of sale program.

It is split into two parts, the front end which is what someone who visits the store sees, as well as a backend, which 
includes all the manual alterations of inventory as well as a list of all the orders and such. It automatically updates
inventory. 

It allows you to print the orders as well as lets you mark the orders as picked or cancel them. 

Dependencies:

This project requires the dompdf and owasp-php-filters libraries, both are included with this project, and both have been altered so that they work with this project.

Layout:

This project is split in two halves, the front, and backend/rear.

Front Pages:

These are the pages that your customer will be interfacing with, they showcase all of your products, and allow customers to place orders.

F_index_front

F_cart

F_checkout

F_place_order

F_product

Rear Pages:

These are the pages that allow you to view customers, view orders, and to update inventory information.

R_add

R_customer_list

R_customer_search

R_customer_history

R_index_rear

R_inventory_screen

R_order

R_print_order

R_save_record

R_update



Setup

Load the pages onto your server, once you have them set up navigate to R_save_record, line 71,

Look for the path to the image folder on your server, and update the target directory. 

On my personal machine it was F:/wamp64/www/Anduin/Images/ but on your machine it may be different, this line is
where uploaded images will live, and also supply the path for the image source for storefront. 

This step can be done with any text editor, once the 