<?php

require_once('ConsultaSeminovos.php');
$brands = ConsultaSeminovos::findBrands();
$models = ConsultaSeminovos::findModels($brands);
