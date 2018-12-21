<?php

class ConsultaSeminovos
{
    public function __construct()
    {

    }
    public static function findBrands()
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.seminovosbh.com.br/',
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        //Extraindo informação para receber as marcas dos carros disponíves no site
        $first_explode = explode('<label for="marca">Marca</label>', $resp)[1];
        $second_explode = explode('<select name="marca" id="marca" title="Marca">', $first_explode)[1];
        $third_explode = explode('<div class="', $second_explode)[0];
        $fourth_explode = explode('<option value="">Escolha uma marca</option>', $third_explode)[1];
        $fifty_explode = explode('<option value="', $fourth_explode);
        unset($fifty_explode[0]);
        $count_of_brands = count($fifty_explode);
        unset($fifty_explode[$count_of_brands]);

        foreach ($fifty_explode as $key => $value) {
            $brand_aux = trim(explode('">', $value)[1]);

            if (strlen($brand_aux) >= 2 && !empty($brand_aux)) {
                $brands[$key] = explode('">', $value);
            }
        }
        return $brands;
    }
    public static function findModels($brands)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.seminovosbh.com.br/json/modelos/buscamodelo/marca/' . $brands[1][0] . '/data.js?v3.44.5-bis',
        ));

        // execute!
        $resp = curl_exec($curl);
        $models = json_decode($resp, 1);

        // close the connection, release resources used
        curl_close($curl);
        return $models;
    }
    public function searchVehicle()
    {

    }

}