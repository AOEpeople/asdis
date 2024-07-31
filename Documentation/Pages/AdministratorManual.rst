.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


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