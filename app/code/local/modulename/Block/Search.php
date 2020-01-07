<?php
/**
 * Product Shipping
 *
 * @package     Adltools_Starshipit
 * @author      Revathi Ganesh
 */

class Modulename_Block_Search extends Mage_Core_Block_Template
{

    public function getSearchUrl()
    {
        return Mage::getUrl('shipit/ajax/getSuburb/',array('_secure'=> true));
    }
}