<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('country_name', function($value) {
                return \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryName($value);
            }),
            new \Twig_SimpleFilter('stripslashes', array($this, 'stripslashesFilter')),
            new \Twig_SimpleFilter('jsondecode', array($this, 'jsondecodeFilter')),
            new \Twig_SimpleFilter('loadjson', array($this, 'loadjsonFilter')),
            new \Twig_SimpleFilter('getsalesmonth', array($this, 'getsalesmonthFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',') {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }

    public function stripslashesFilter($string) {

        return stripslashes($string);
    }

    public function jsondecodeFilter($string) {
        return json_decode($string);
    }

    public function loadjsonFilter($string) {
        $str = file_get_contents($string);
        return json_decode($str);
    }

    public function getsalesmonthFilter($res) {
        $valMonths = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($res as $month) {
            $valMonths[(int) $month['gMonth'] - 1] = $month['tots'];
        }
        return $valMonths;
    }

    public function getName() {
        return 'app_extension';
    }

}
