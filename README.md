TYPO3 CMS New Relic Integration
===============================

A collection of integration improvements for web sites using New Relic performance monitoring. Focuses on separating
various transactions into more sensible groupings, such as by page UID, and uses a few well-placed hook subscribers to
declare DataHandler commands such as copy, delete etc. as transaction names so you can dig deeper and monitor the
performance of each type of operation.

Credits
-------

All of the work that went into creating this extension has been kindly sponsored by [Systime A/S](https://systime.dk/).
Do give them a visit - they make interactive, online educational material and they use TYPO3 in all of their productions.

What does it do?
----------------

In a few words: it greatly enhances the detail of information you get from New Relic about your TYPO3 site.

When installed, the extension adds a number of extremely light-weight closures and hook subscribers which take care of
properly naming the transaction you see in New Relic, takes care of adding special tracing instructions to report
metrics about things like Fluid template rendering performance and TypoScript parsing. The integrations are light-weight
enought that they *can* be used in production sites.

Each and every type of reporting can be toggled individually to select exactly the set of details and metrics you want.

How to install
--------------

The extension is intentionally only available when installing with Composer:

```
composer require namelesscoder/typo3-cms-newrelic-integration
```

Then activate the extension in Extension Manager or run the following command:

```
./typo3/cli_dispatch.phpsh extbase extension:install newrelic_integration
```

When you've installed the extension make sure you visit the extension configuration panel in Extension Manager on the
right side of where this extension is listed. Toggle any tracers off that you don't wish to track in New Relic.

What does it track?
-------------------

Depending on which tracers you enable, you can track any of the following:

#### In backend and frontend

* User logins as a separate transaction (in case you have a remote authentication service and want to monitor
  performance when your site communicates with the authentication service).
* User name, company and UID as custom parameters in transaction traces.
* Class instancing tracers to keep track of time spent on creating classes (the more your site users for rendering a
  page, the more pressure this puts on I/O, opcache, etc).
* Extbase controller calling on three dimensions; request processing, action init and pure calling of action methods.
* Extbase persistence on a very general level; tracing of query execution and property mapping only.
* Cache operations to get, set, flush and flush by tags (where supported) on all TYPO3 shipped cache backends.
* Fluid template parsing
* Fluid template rendering (with dimensions for rendering templates/layouts, partials or sections)

#### In frontend

* Page UID is optionally included in transaction name to allow monitoring individual pages' performance.
* Special typeNum included in transaction name if set.

#### In backend

* DataHandler commands as individual transactions (copy, delete, undelete, move etc. tracked separately)
* Page layout as individual transaction, to allow tracing this module that is very frequently used by editors.

#### In CLI

* Command name used as part of transaction name, to allow you to monitor each command separately.

Homage
------

A shout-out is appropriate here to another TYPO3 extension which also integrates TYPO3 and New Relic - and that's
https://github.com/AOEmedia/TYPO3-Newrelic from AOEmedia. Respect for having created that! Unfortunately, that project
hasn't been maintained for more than three years.

So, I think that this extension has the advantage that it's more current and is appropriate for TYPO3v8 series.
And the capability to track in particular frontend requests, but also individual CLI commands by their name, should
yield a bit more practical information for "modern" (excuse the buzzword, but you know what I mean) TYPO3 sites.
