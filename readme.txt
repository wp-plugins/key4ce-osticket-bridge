=== Key4ce osTicket Bridge ===
Contributors: key4ce, m.tiggelaar, emiprotech
Tags: helpdesk, support, ticket, osticket, bridge, email, email ticket system
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40key4ce%2ecom
Requires at least: 3.1
Tested up to: 3.9
Stable tag: 1.1.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

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
* Contact form shortcode

= Fixes/ new Features: =

* osTicket keyost_prefix field
* Shortcode Implementation to avoid Theme issues
* Reply Separator Tag fix
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

This plugin is powered by Key4ce - IT Professionals :: http://www.key4ce.com

== Installation ==

* Make sure that osTicket is installed
* Make sure that your osTicket version is 1.8 or 1.9
* osTicket can be downloaded from http://osticket.com/download

Shortcodes:
[addosticket]  for After login  Ticket listing and Creation of tickets
[addoscontact]  For a contact style form with captcha.

1. Install key4ce-osticket-bridge folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Plugin settings are located in Dashboard--> Tickets --> osT-Config
4. Plugin settings are located in Dashboard--> Tickets --> Settings
5. Plugin settings are located in Dashboard--> Tickets--> Email Templates
6. You can use the shortcode: [addosticket]


== Frequently Asked Questions ==
= Where does the osTicket need to be Installed? =
Can be anywhere, just make sure you know it's Database settings and fill them in accodringly in osT-Config page.

= What version of osTicket can i use? =
osTicket v1.8 and v1.9
Recommended version is 1.9.

= Where can I download the tested osTicket versions? =
http://osticket.com/download

== Screenshots ==
1. Shows the Client ticket list.
2. Shows how the client views the ticket.
3. Shows how the Wordpress admin views the ticket list.
4. Shows how the Wordpress admin views the ticket.

== Changelog ==
= 1.1.5 =
- Shortcode for Contact style form with captcha
- Shortcode placement fix for ticket list and ticket create
- CSS/ JS inclusion fix ** Submitted by sldayo **
- Login Redirect ** Submitted by sldayo **


= 1.1.4 =
- Prefix fix for existing plugin users
- mysql DB errors fixed
- RevSlider conflict fixed
- Activate / Deactivate warning messages fixed.
- If wrong database info blank page issue fixed.

= 1.1.3 =
- Added database keyost_prefix field
- Fixed mysql bugs
- Fixed first time user issue.
- Headers already sent fixed.
- Creating multiple ticket pages on save has been resolved.

= 1.1.2 =
- Shows name in ticket threads.
- SMTP save field fix
- Offline / Offline mode fix
- Cleaned up legacy code

= 1.1.1 =
- Shortcode redirect fix
- Login fields added
- Register link with redirect added
- Premalink related issues fixed
- Adding new users to OSticket fixed
- Form validation fixed

= 1.1 =
- Shortcode implementation
- Cleaned up code issues
- Admin Alert Email now looks into group members aswell
- implemented Reply Separator Tag
- Fixed: Email From name
- Fixed: Many code warnings and errors in Debug mode
- And much more..

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
= 1.1.5 =
Shortcode fixes, css/js inclusion fixes, new Contact style shortcode

= 1.1.4 =
Urgent update fixing multiple issues caused by update 1.1.3.

= 1.1.3 =
Database keyost_prefix field added, and mysql bugs fixed.

= 1.1.2 =
Minor update: Cleaned up legacy code and fixed:smtp fields and offline mode

= 1.1.1 =
Shortcode related issues fixed, osTicket user related issues fixed.

= 1.1 =
Shortcode implementation and many code fixes.

= 1.0 =
Initial version