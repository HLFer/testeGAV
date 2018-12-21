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
                $brands[$key] = $brand_aux;
            }
        }
        return $brands;
    }
    public static function findModels()
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

        $first_explode = explode('<label for="modelo">Modelo</label>', $resp)[1];
        $second_explode = explode('<select name="modelo" id="modelo">', $first_explode)[1];
        $third_explode = explode('<div class="', $second_explode)[3];
        $fourth_explode = explode('<label for="ano1">Ano/Modelo</label>', $third_explode)[1];
        $fifth_explode = explode('<dd>', $fourth_explode)[1];
        $sixth_explode = explode('<select name="ano1" id="ano1" class="valor1"><option value="">De</option>', $fifth_explode)[1];
        $seventh_explode = explode('<dl>', $sixth_explode)[0];
        $eigth_explode = explode('<option value="', $seventh_explode);
        unset($eigth_explode[0]);
        $year_of = [];
        //Criação da data inicial da busca
        foreach ($eigth_explode as $key => $value) {
            $date_aux = trim(explode('">', $value)[1]);
            if (strlen($date_aux) >= 2 && !empty($date_aux)) {
                $year_of[$key] = $date_aux;
            }
        }

        $tenth_explode = explode('<dl>', $fourth_explode)[1];
        $eleventh_explode = explode('<select name="ano2" id="ano2" class="valor1"><option value="">Até</option>', $tenth_explode)[1];
        $twelfth_explode = explode('<dl>', $eleventh_explode)[0];
        $thirteenth_explode = explode('<option value="', $twelfth_explode);
        unset($thirteenth_explode[0]);

        $year_until = [];
        //Criação da data inicial da busca
        foreach ($eigth_explode as $key => $value) {
            $date_aux = trim(explode('">', $value)[1]);
            if (strlen($date_aux) >= 2 && !empty($date_aux)) {
                $year_until[$key] = $date_aux;
            }
        }

        $date = [
            'of' => $year_of,
            'until' => $year_until
        ];
        return $date;
    }

}