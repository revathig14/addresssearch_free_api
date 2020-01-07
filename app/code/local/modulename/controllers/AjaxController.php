<?php
class Modulename_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    //input: postcode returns suburb
    public function getSuburbAction()
    {
        $postcode = $this->getRequest()->getParam('postcode');
        $result = array ();
        $url  = Mage::getStoreConfig("starshipit/address_search_api/genoname_api_url");
        $username  = Mage::getStoreConfig("starshipit/address_search_api/geoname_username");

        if (isset($url) && isset($postcode) && isset($username)) {
            $url .= '&postalcode='.$postcode.'&'.'username='.$username;
        } else
            $result['error'] = 'Something went wrong! Please contact our support.';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, "Content-Type: application/json");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);
        if (!empty($response['postalcodes'])) {
            $result['success'] = true;
            foreach ($response['postalcodes'] as $key => $value)
                $result['suburb'][] = $value['placeName'];
        } else
            $result['error'] = 'Postal code is invalid. Please try again with valid post code!';

        return $this->getResponse()->setBody(json_encode($result));
    }
}