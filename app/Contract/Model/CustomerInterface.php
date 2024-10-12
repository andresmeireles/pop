<?php

namespace App\Contract\Model;

interface CustomerInterface extends ModelInterface
{
    public function getCompanyName(): string;
    
    public function getTradeName(): string;
    
    public function getCnpj(): string;
    
    public function getCity(): string;
    
    public function getState(): string;
    
    public function getEmail(): string;
}