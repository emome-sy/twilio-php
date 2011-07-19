Twilio API helper library

## Installing

Via PEAR:

    pear install channel://pear.php.net/Net_URL2-0.3.1
    pear install channel://pear.php.net/HTTP_Request2-2.0.0RC1
    pear install channel://twilio.github.com/pear/Services_Twilio-0.0.3

## Indenting

To comply with PEAR standards, this project keeps an indent of 4-spaces
(http://pear.php.net/manual/en/standards.indenting.php). Git attributes with
smudge and clean filters can be used to configure an alternative indent.

1. Create a .gitattributes file in the project root.

    $ echo "*.php filter=tabspace" >> .gitattributes

2. Set up smudge and clean filters. On check-out (i.e. smudge), the filter should
convert a 2-space indent to 4-space indent. To indent using tabs, for example:

    $ git config filter.tabspace.smudge 'unexpand -t4'

And a corresponding filter should be set up code that's checked-in (i.e.
clean):

    $ git config filter.tabspace.clean 'expand -t4'