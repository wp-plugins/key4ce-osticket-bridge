=== Key4ce osTicket Bridge ===
Contributors: key4ce, m.tiggelaar
Plugin Name: Key4ce osTicket Bridge
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40key4ce%2ecom
Tags: helpdesk, support, ticket, osticket, bridge, email, email ticket system,
Requires at least: 3.1
Tested up to: 3.9
Stable tag: 1.0
License: GPLv3

Get your own advanced ticket system in Wordpress and Integrate osTicket into your wordpress site. Works with osTicket v1.8 and 1.9

== Description ==

This is a rebuild of the original OSTicket WP Bridge plugin.

Because the original plugin was no longer developped we desided to make a new plugin out of it.
adding new features, fixing old bugs and security flaws.

= Basic Features: =

* Compatible with osTicket 1.8 and 1.9
* POP / IMAP functionality stays intact
* You can use both osTicket scp, reply to email OR use Wordpress for all tickets
* Integrates with your Wordpress users
* Good workflow of Open, Answered and Closed tickets.


= Fixes/ new Features: =

* New design for both Admin and Client end
* Uses OSTicket email address and name based up on the department
* Full HTML capable with rich text editor for both client and admin
* Admin side menu displays the amount of open tickets
* Displays "Open tickets" in the top admin menu when open tickets are available Displays "Support tickets" when no open ticket is available.
* Added Answered status to both admin and client side
* Security Fix: Client no longer able to see everyones ticket by entering the ticket id in the url.
* Fix: User/ priority/ status fields compatible with OSTicket 1.9
* Fix: Using department instead of Topic
* Fix: If not logged in to Wordpress it will redirect you to the Wordpress login (works with Theme my login plugin) 

This plugin is powered by Key4ce - IT Professionals :: http://key4ce.com

== Installation ==



1. Install key4ce-osticket-bridge folder to the /wp-content/plugins/ directory.

2. Activate the plugin through the "Plugins" menu in WordPress.

3. Plugin settings are located in Dashboard--> Tickets --> osT-Config

4. Plugin settings are located in Dashboard--> Tickets --> Settings

5. Plugin settings are located in Dashboard--> Tickets--> Email Templates



== Frequently Asked Questions ==



= Where does the osTicket need to be Installed? =


Can be anywhere, just make sure you know it's Database settings and fill them in accodringly in osT-Config page.



= What version of osTicket can i use? =


osTicket v1.8 and v1.9

Recommended version is 1.9.



= Where can I download the tested osTicket versions? =



http://osticket.com/download



= Why does the welcome page not displaying right? =


Each theme is differant, you can open the (page.php) file in the theme folder and copy the header/footer part (not the content statement) into the header and footer files located in the (key4ce-osticket-bridge/templates/) folder. These two files will have instructions.

You can also adjust the (style.css) file located in (key4ce-osticket-bridge/css/) folder. At the top look for (#ost_container) set the margin: 20px 20px 20px 20px; to your needs. 

== Screenshots ==

1. Shows the Client ticket list
2. Shows how the client views the ticket
3. Shows how the Wordpress admin views the ticket list
4. Shows how the Wordpress admin views the ticket

== Changelog ==

= 1.0 =
- New design for both Admin and Client end
- Uses OSTicket email address and name based up on the department
- Full HTML capable with rich text editor for both client and admin
- Admin side menu displays the amount of open tickets
- Displays "Open tickets" in the top admin menu when open tickets are available Displays "Support tickets" when no open ticket is available.
- Added Answered status to both admin and client side
- Security Fix: Client no longer able to see everyones ticket by entering the ticket id in the url.
- Fix: User/ priority/ status fields compatible with OSTicket 1.9
- Fix: Using department instead of Topic
- Fix: If not logged in to Wordpress it will redirect you to the Wordpress login (works with Theme my login plugin)

== Upgrade Notice ==

= 1.0 =
Initial version