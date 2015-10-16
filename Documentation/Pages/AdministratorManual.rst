.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

The first thing you have to decide, when installing asdis, is the exact moment you want to replace the URLs to your CDN.

Your options are:

- Before Storing in cache (contentPostProc-all) (recommended)

- Before outputting the content to the browser (contentPostProc-output)

- Non INTincScripts before storing in cache (contentPostProc-all) + INTincScripts before outputting the content to the browser (contentPostProc-output)

The description in your backend explains your options very well:

.. image:: /Images/AdministratorManual/AsdisConfig1.png

----------
Activation
----------

To enable Asdis add some TypoScript to your Page Template:
.. parsd-literal::

 config.tx_asdis {
   enabled = 1
   servers {
     media1 {
       domain = media1{$const.cdn.domain}
     }
     media2 {
       domain = media2{$const.cdn.domain}
     }
   }
 }