<?php

namespace Proglab\PrintSmarterApiClient\Dto;

class Order
{
    public string $order_id_client = '#TEST1';
    public string $shipping_code = 'Standard';
    public Address $shipping_address;
    public Address $return_address;

    public function __construct()
    {
        $this->shipping_address = new Address();
        $this->return_address   = new Address();
    }

    /**
     * @var array<int, Product>
     */
    public array $products = [];

}
