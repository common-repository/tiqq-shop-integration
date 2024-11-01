=== tiqq shop integration ===
Contributors: jurrevanderschaaf
Tags: tiqq, tickets, ticket shop
Requires at least: 3.0
Tested up to: 6.4
Stable tag: 1.3
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://tiqq.io/wordpress-plugin

This plugin allows organizers to easily integrate their ticket shop on their own website.

== Description ==
# tiqq Wordpress plugin
This plugin allows organizers to easily integrate their ticket shop on their own website. Create a project and shop first on [tiqq.io](https://tiqq.io).

## This plugin relies on a 3rd party service
The goal of this plugin is to integrate an organizers ticketing shop onto their website. As the ticketing shop is manged and served by 'tiqq', this party calls are made by means of an iframe. In this iframe, the shop is displayed and if the visitor decides to start an order, this is all handled by the 3rd party "tiqq".

Data is only collected if a visitor explicitely fill in their information to buy a ticket. Data collected is only used to provide the visitor with a ticket, and nothing else.

The terms and conditions (https://tiqq.nl/algemene-voorwaarden) and privacy policy (https://tiqq.nl/privacy-statement) apply. The visitor is notified about this before the data is delivered to the system.

## Basic usage
1. Create a project and shop on our website, [tiqq.io](https://tiqq.io)
2. Install and activate this plugin
3. Add the following shortcode at the page where you want to include your ticket shop: `[tiqq shop="<shop keyword>"]`

Here, `<shop keyword>` is the chosen keyword in your shop settings. E.g. if the link to your shop is `https://tiqq.shop/demo`, then your keyword is `demo`.

## Advanced usage
You can add attributes to the shortcode to give style your integration:

* `accent-color="<hex value>"`  
  This color is used for buttons, texts and other accents. This way, your shop will integrate better in your website. E.g.: `accent-color="009900"` for green.

* `accent-prime-color="<hex value>"`  
  Comparable with accent-color, but this color is used for example when a button is hovered. We advise to use a slightly darker variant of the color chosen at accent-color. E.g.: `accent-color="005500"` for dark green.

* `style="..."`  
  If desired, you can add default css values to the frame. For reference, please see: [https://www.w3schools.com/tags/att_style.asp](https://www.w3schools.com/tags/att_style.asp)


## Cart option (advanced)
Another advanced feature is available, where products can be added to a cart on mulitple pages, and the cart can be viewed and ordered at a separate page.

#### Add to cart
On pages where you want people to add products to their cart, add:
```
[tiqq_add_to_cart shop="<shop keyword>" product="1234"]
```
Here, add the shop keyword (same as under "basic usage"), and add the product id gathered from your settings on our website, to the field `product`.

#### Display cart
On pages where you to display the cart, add:
```
[tiqq_cart shop="<shop keyword>"]
```
Here, add the shop keyword (same as under "basic usage").

## Questions
If you have any questions about this plugin, please contact us via [tiqq.io/support](https://tiqq.io/support).