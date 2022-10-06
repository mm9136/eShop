# eShop - spletna trgovina
Online sales model using Linux, Apache, SUBP MySQL, PHP, SSL, X.509 certificates and Android mobile platforms.

Online sales have the following users, with the above attributes preserved:

- Administrator: First name, last name, email address and password

- Seller: First name, last name, e-mail and password.

- Customer: First name, last name, email address, phone number, password.

- Anonymous client where you don't store attributes.

BASIC SERVICES:
Core commerce services support the following operations in each role.
1. Online/web interface of the ADMINISTRATOR role
The interface enables:
• Log-in and log out. Access is allowed only to clients authenticated using X.509 certificates;
• Updating own password and other attributes
• Adding, activating and deactivating the Seller (seller) user account and updating its attributes.
You can have only one user in the role of administrator, which you can create manually, for example using a certain script, phpadmin and the like.
2. Online/web interface of the SELLER role
• Log-in and log out. Access is allowed only to clients authenticated using X.509 certificates;
• Updating own password and other attributes
• Creating/adding, activating and deactivating products and their attributes. When handling items, you can omit inventory management. In other words - you can always assume that there are enough items in the application
• Adding, activating and deactivating user accounts of the Customer and updating its attributes.
3. Online/web interface of the CUSTOMER role
The interface enables:
• Log-in and log out.
• Updating own password and other attributes
• Shopping. There is a composition of:
 - review of trade items
-adding and removing items to the shopping cart and changing the quantity in the shopping cart
- finish purchase. There, the customer is first shown a summary of the purchased products with a preliminary invoice. When the customer confirms the order, it is added to the waiting list of unfulfilled orders, where it can be taken into consideration by the Seller.
• Access to the list of previous purchases. The user can see all his previous orders: submitted, confirmed and canceled.
• The use of the interface by the Customer is allowed only through a protected channel. Verify the client with a username and password that should be saved in SUPB.

4. Online/web interface of ANONYMOUS USER
The interface allows:
• review of trade items
• registration through the online interface
• the use of the anonymous user interface is allowed through the public and protected channel, when registering you must switch to the protected channel. In general, check that you have switched between the two channels correctly.

5. Mobile application interface (Android platform)
Android application, which allows easier viewing of items in store.
• The network service interface, through which the mobile application communicate with store.
• Product browsing functionality:2 screens:
- the first screen shows a list of all products in the store.
- if the user selects a product from the above list, the application display another screen, where the features/characteristics of the product are listed.

6. Other requirements
Your solution meets the following requirements:
• own certified agency and a digital confirmation of the server was made with it. The digital certificate is installed on the Apache service.
• Self-certificates are created manually with a dedicated program and using the same certification agency that was used to create the service's certificate. The fields of the certificate were used meaningfully and the identity of the user in the database was connected in an appropriate way with the identity written on the certificate.
• during the implementation of all parts of the store, the client's input was checked, paying particular attention to SQL code injection attacks and XSS attacks.
• The methods of the HTTP protocol are implemented in accordance with the recommendations of the HTTP standard (with the GET method for simple operations and for complex requests with the POST method)
• for proper password storage
• the created database model is normalized to the third normal form

EXTENDED SERVICES - USER INTERFACE
• organization and execution of the user interface using technology such as CSS and JavaScript. Also the use of AJAX technology.
• searches by articles. Search supports binary search (https://dev.mysql.com/doc/refman/5.5/en/fulltext-boolean.html), i.e. queries where we can exclude certain search terms using special operators
• presenting the article with a picture.
