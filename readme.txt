=== Key4ce osTicket Bridge ===
Contributors: key4ce, m.tiggelaar
Tags: helpdesk, support, ticket, osticket, bridge, email, email ticket system
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40key4ce%2ecom
Requires at least: 3.5
Tested up to: 4.2
Stable tag: 1.2.9
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Get your own advanced ticket system in Wordpress and Integrate osTicket into your wordpress site. Works with osTicket 1.9.3 - 1.9.7

== Description ==
This is a rebuild of the original OSTicket WP Bridge plugin
Because the original plugin was no longer developed we decided to make a new plugin out of it.
adding new features, fixing old bugs and security flaws.

= Basic Features: =
* Compatible with osTicket 1.9.3 - 1.9.7
* POP / IMAP functionality stays intact
* You can use both osTicket scp, reply to email OR use Wordpress for all tickets
* Integrates with your Wordpress users
* Good work-flow of Open, Answered and Closed tickets.
* Contact form shortcode
* Multiple file attachments
* HTML Email templates.
* Admin and Department signatures from osTicket.
* Create ticket as Admin.
* Multi-language support

= Features scheduled for next release: =
- Add Topic functionality to create tickets.
- Ticket user linked to WP / Woo Commerce users.
- osTicket based user and global time settings.

= Translations available =
* English
* Dutch
* Arabic - by mbnoimi
* German - by Adrian Oeschger
* If you would like to contribute your own language please don't hesitate to contact us!

= If you like this plugin please leave a good review behind and help us to promote it. = 
This plugin is powered by Key4ce - IT Professionals :: https://key4ce.com

== Installation ==

= Prerequisites: =
* Make sure that osTicket is installed
* Make sure that your osTicket version is 1.9.3, 1.9.4 1.9.5, 1.9.6 or 1.9.7 (all subversions should work).
* osTicket can be downloaded from http://osticket.com/download
* For Attachments to work with the Key4ce osTicket Bridge plugin, please download and configure the osTicket plugin: Storage :: Attachments on the Filesystem
* osTicket Storage :: Attachments on the Filesystem plugin can be downloaded here: http://osticket.com/download/go?dl=plugin%2Fstorage-fs.phar
* Our plugin will make use of Department alert & Email settings. Please set them carefully in osTicket settings.
* Create a Contact Ticket Page. This is the page the plugin will modify and AUTOMATICALLY insert the [addoscontact] shortcode which will display a contact form which allows guests to submit tickets
* Create a Thank You Page for all ticket submissions

= Shortcodes: =
[addosticket] Ticket listing and creation of tickets for logged in customers/clients (see Screenshots tab).
[addoscontact] Guest ticket submission form with CAPTCHA (a WordPress user login is not required to submit a ticket - see Screenshots tab).
[addosopenticketcount] Display the amount of open tickets for the logged in user anywhere in wordpress.

= Install Instructions: =
1. Install key4ce-osticket-bridge folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. osTicket Bridge plugin settings are located in Dashboard--> Tickets --> osT-Config (DO NOT name your "Landing Page Name" the same name as the folder you have osTicket installed).
4. osTicket DB configuration settings are located in Dashboard--> Tickets --> Settings
5. Email template settings are located in Dashboard--> Tickets--> Email Templates

= IMPORTANT NOTE: =
You CANNOT use the shortcode: [addosticket] and [addoscontact] on more than one page. Please make sure you select the corresponding pages you applied the shortcodes to in the osTicket Bridge plugin settings (located in Dashboard--> Tickets --> osT-Config).

== Frequently Asked Questions ==

= Where does the osTicket need to be Installed? =
Can be anywhere, just make sure you know it's Database settings and fill them in accordingly in osT-Config page.

= What version of osTicket can i use? =
osTicket v1.9.3 to v1.9.7 (all subversions are generally supported).

= Where can I download the tested osTicket versions? =
http://osticket.com/download

== Screenshots ==

1. Shows the Client ticket list.
2. Shows how the client views the ticket.
3. Shows how the Wordpress admin views the ticket list.
4. Shows how the Wordpress admin views the 
5. Shows the [addoscontact] shortcode forms
6. HTML Email template example (with signature).

== Changelog ==
= 1.2.9 =
- Added additional File attachment functionality to ignore empty extensions
- Fixed up queries for shortcode/ forum contact page

= 1.2.8 =
- Added support for 1.9.5.1 and 1.9.6
- fixed Attachment support for higher versions

= 1.2.7 =
- Functions all have prefixes to avoid conflicts with other plugins
- Multi language support added

= 1.2.6 =
- Fixes for 1.9.4 fresh installation
- Email customer reply fix

= 1.2.5 =
- osticket 1.9.4 support added
- added osticket version selection

= 1.2.4 =
- Open ticket count fixed
- Option to enable ticket close for client
- Client layout fixed
- Client main page fixed
- Small other changes in code.

= 1.2.3 =
- Admin can create tickets with auto search in WP Database.
- Mass close tickets on client ticket listing.
- Shortcode for viewing open tickets
- File attachment error in Admin fixed.
- Bugged users will now be automatically updated and fixed.
- contact form bug fixed.

= 1.2.2 =
- Multiple file attachments
- File attachment location from osTicket
- mysql query fix- contact form sender name and email fix.
- minor issues fixed.- updated installations (Contributed by: DivaVocals)

= 1.2.1 = 
- Fixed infected javascript files.

= 1.2.0 = 
- Single file Attachments
- File Attachement configuration based on OSticket(Filesize,File Type,File Attachement enable/disable)
- Corrected Admin ticket counting (Open,Closed,Answered,All)
- HTML Email Template
- Admin and Department Signature in Email template (based up on osTicket signature)
- Mass delete/ Close tickets from Admin ticket listing
- Fixed names in ticket thread
- Fixed time equal to osTicket settings.
- Tested with Wordpress 4.0

= 1.1.5 =
- Shortcode for Contact style form with captcha
- Shortcode placement fix for ticket list and ticket create
- CSS/ JS inclusion fix ** Submitted by Steffen Andre Langnes **
- Login Redirect ** Submitted by Steffen Andre Langnes **

= 1.1.4 =
- Prefix fix for existing plugin users
- mysql DB errors fixed- RevSlider conflict fixed
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
- SMTP save field fix- Offline / Offline mode fix
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
- implemented Reply Separator Tag- Fixed: Email From name
- Fixed: Many code warnings and errors in Debug mode- And much more..

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
= 1.2.9 =
Added better attachment support and fixed up some queries for contact page.

= 1.2.8 =
Added support for 1.9.5.1 and 1.9.6

= 1.2.7 =
Added multi language support.

= 1.2.6 =
Added osticket 1.9.4 fresh installation support and small email customer reply bug.

= 1.2.5 =
Added osticket 1.9.4 support.

= 1.2.4 =
Option to enable or disable client close ticket feature, and small bug fixes.

= 1.2.3 =
Several minor bug fixes, new Admin create ticket functionality, and more..

= 1.2.2 =
Multiple file atachment now possible, and small bug fixes have been made.

= 1.2.1 =
Emergency update: Javascripts where infected please update asap. Our apologies for the inconvenience

= 1.2.0 =
Multiple new and convenient features, Attachments, signatures and more.

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