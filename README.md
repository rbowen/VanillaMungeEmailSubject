# MungeEmailSubject

Vanilla Forums provides ways to customize the body of various email notifications that get sent out, but the subject lines are not part of that.

This plugin provides a way to change the email subject from "Foo started a discussion" to the actual title of the discussion that they started.
It also puts a "Re: Subject Line", and an In-Reply-To header on replies to that discussion, so that your email client will thread them correctly.

Other activity types are not handled, but could be added trivially, once you see how the plugin works.

While the question of how to do this appears numerous places in the Vanilla support forum, I wasn't able to find any actual solutions to the problem.

## TODO

* Use ActivityType name rather than ID number, which is evil

## Contact

* Rich Bowen
* rbowen@rcbowen.com
* http://rcbowen.com/
* @rbowen
