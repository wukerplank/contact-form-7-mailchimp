# Contact Form 7 Mailchimp

This Wordpress plugin is an extension to the widely used [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin. This extension enables you to configure a the contact form to push newly submitted data to [Mailchimp](http://mailchimp.com/). This plugin uses the Mailchimp API v3.

## Dependencies

You will at least need PHP 5.3 on your host to use this plugin.

HTTP requests to the Mailchimp API are made via CURL, so make sure it is availabel on your host. On most Debian/Ubuntu hosts you should be able to install the PHP CURL package with

    sudo apt-get install php5-curl

## Usage

This extension adds another form box to your Contact Form 7 administration. To make this extension work you have to provide

 - your Mailchimp API key (you can get one on their website)
 - the ID of the list you wish to submit your new contacts to
 - the names of several input fields of you form containing information about:
   - firstname of the subscriber
   - lastname of the subscriber
   - email of the subscriber
   - acceptance field for the subscriber's opt-in
 - optionally you may also provide a list of fields you also want to send to the mailchimp list

### Acceptance field

If you leave the acceptance field empty the subscriber will be added to your list no matter what. **Warning:** This might be illegal in your country! You may be required to let the subscriber opt-in to your newsletter.

If you provide an accepance field its value will be interpreted like this:

Interpreted as **yes**:
 - ok (case ignored)
 - yes (case ignored)
 - true (case ignored)
 - 1

All other values (including an empty field) will be interpreted es **no**.

## Example

Let's assume you have a form like this:

    <p>Firstname<br />
    [text* firstname]</p>

    <p>Lastname<br />
    [text* lastname]</p>

    <p>Pet's name<br />
    [text* pets_name]</p>

    <p>eMail<br />
    [email* email]</p>

    <p>[radio subscribe default:2 "Yes" "No"] I would like to subscribe to your newsletter</p>

Then your Mailchimp configuration should look like this:

![screenshot of a filled out Mailchimp form](https://raw.githubusercontent.com/wukerplank/contact-form-7-mailchimp/master/documentation/example.png)

## Tests

I tried to cover as much functionality as possible. Right now the wrapper for the Mailchimp API is untested. I'm pretty new to PHP testing and I need to find a way to test the gem without hitting the Mailchimp API constantly.

In order to run the tests you need to have (PHPUnit)[https://phpunit.de] installed. You can run the tests like this:

    cd path/to/contact-form-7-mailchimp
    phpunit tests/*

## Thanks & Acknoledgements

This extension is based and inspired by Renzo Johnson's [Contact Form 7 MailChimp Extension](https://wordpress.org/plugins/contact-form-7-mailchimp-extension/). Sadly, at the time of writing it was broken and inserted HTML with backlinks into the public facing Contact Form 7 output.

## To-Do

 - [ ] Add a toggle field and collapse the whole fieldset
 - [ ] Make custom fields more dynamic (add/remove buttons)
 - [ ] Provide an option to create a new list
 - [ ] Tests for the Mailchimp API wrapper

## License & Copyright

Copyright (c) 2015 Christoph Edthofer

This software may be modified and distributed under the terms of the MIT license. See the LICENSE file for details.
