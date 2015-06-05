# Contact Form 7 Mailchimp

This Wordpress plugin is an extension to the widely used [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) plugin. This extension enables you to configure a the contact form to push newly submitted data to [Mailchimp](http://mailchimp.com/).

## Usage

This extension adds another form box to your Contact Form 7 administration. To make this extension work you have to provide

 - your Mailchimp API key (you can get one on their website)
 - the ID of the list you wish to submit your new contacts to
 - the names of several input fields of you form containing information about:
   - name of the subscriber
   - email of the subscriber
   - acceptance field for the subscriber's opt-in
 - optionally you may also provide a list of fields you also want to send to the mailchimp list

## Example

Let's assume you have a form like this:

    <p>Name<br />
    [text* name]</p>

    <p>Pet's name<br />
    [text* pets_name]</p>

    <p>eMail<br />
    [email* email]</p>

    <p>[radio subscribe default:2 "Yes" "No"] I would like to subscribe to your newsletter</p>

Then your Mailchimp configuration should look like this:

![screenshot of a filled out Mailchimp form](https://raw.githubusercontent.com/wukerplank/contact-form-7-mailchimp/master/documentation/example.png)

## License & Copyright

Copyright (c) 2015 Christoph Edthofer

This software may be modified and distributed under the terms of the MIT license. See the LICENSE file for details.
