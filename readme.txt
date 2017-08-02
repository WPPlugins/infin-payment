=== infin-Payment ===
Contributors: infin
Tags: payment
Requires at least: 3.0
Tested up to: 4.5

Description: This plugin allows you to integrate all popular online payment methods in your WordPress WP e-Commerce webshop like: calls from landline networks, calls from mobile networks, SMS payments and credit card payments with no registration.
The plugin grants you access to all the great infin-Payment features. You can offer your users the possibility to pay via SMS and Call in your webshop.

Version: 1.00 [2016.07.04]
Author: Harald Singer
Author URI: http://www.infin.de
License: GPL2

Copyright 2016  infin - Ingenieurgesellschaft für Informationstechnologien  mbH & Co. KG (email : office@infin.ro)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

== Description ==
infin-Payment WP e-Commerce plugin 

This plugin allows you to integrate all popular online payment methods in your WordPress WP e-Commerce webshop like: calls from landline networks, calls from mobile networks, SMS payments and credit card payments with no registration.
The plugin grants you access to all the great infin-Payment features. You can offer your users the possibility to pay via SMS and Call in your webshop.

Why infin-Payment PremiumPosts for WordPress?

Here's why:
	Your users can choose the payment methods they like most: via SMS and via Call
	You get better conversion rates because people trust these payment methods from infin
	You increase the number of users because they love to stay anonymous - which they can with these payment methods. So you even reach new target groups.
	You cover more than 120 countries with just ONE plugin from infin. Don't bother about the rest, infin does that for you.
	You wonder about the support? You can count on infin. Our professionals are there for your users. And besides, they might not even really need us, as the system works just great.
	You have total transparency regarding the payment flows through easy-to-use extra tools from infin.

== Installation ==
- install the plugin via the usual wordpress install
- configure your settings in wp-admin Settings/infin-Payment

== Frequently Asked Questions ==
Usage:
- create a premium-post (menu: Premium Posts)
- at the end of the edit form you can set a price (in EUR - format with decimal point, ex. 4.99 )
- insert the premium-post into any page using the shortcode 
  [infin_payment_posts id=1714] or [infin_payment_posts id='all'] - displays the premium-content with the ID 1714 or all of them... 

== Screenshots ==
1. infin-Payment interface
2. using the infin-payment-shortcode
  
== Changelog ==
What's new:
The callback function (which is called by the payment-framework) no longer resides in the wordpress-plugin-folder - but is located at infin's own servers.
In this way, the plugin checks over http if a given premium content has been paid or not (yet).

Demo:

Go to:
http://blog.infin.de/?page_id=1692

There you see possible premium-content for 0.10 EUR and a button "Pay with infin-Payment"
Press the "Pay..." button (do not bother - it won't cost you money :)
A payment-window opens. Select there Germany as country (in the bottom right part of the window). 
Normally you will call a premium-rate-phone-number to pay but, for demo-purposes let's just pretend you called and got the TAN "infin".
So, enter "infin" (without the quotes) into the field and press Next.
Payment should look fine and, after, closing the payment-window, the premium-content on our blog should be visible (as long as your browser-session is active).

Thanks for testing :)