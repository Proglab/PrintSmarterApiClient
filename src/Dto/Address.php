<?php

namespace Proglab\PrintSmarterApiClient\Dto;

class Address
{
    public string $first_name = 'Max';
    public string $last_name = 'Mustermann';
    public ?string $company;

    public string $address1 = 'Am Stillflecken 4';
    public ?string $address2;
    public string $city = 'Donauwörth';
    public string $zip = '86609';
    public string $country_code = 'DE';
    public string $country = 'Germany';
    public string $email = 'max@mustermann.de';
}
