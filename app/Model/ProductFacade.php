<?php

declare(strict_types=1);

namespace App\Model;

use Nette;



final class ProductFacade{

    private Nette\Database\Explorer $database;

    private const
        TABLE_NAME = 'Products',
        COLUMN_ID = "id",
        COLUMN_NAME = "Name",
        COLUMN_DESCRIPTION = "Description",
        COLUMN_PRICE = "Price";

    public function __construct(Nette\Database\Explorer $database){
        $this->database = $database;
    }
    
    public function getAll(){
        return $this->database
            ->table(self::TABLE_NAME)
            ->fetchAll();
    }

    public function addProduct($name, $price, $description){
        $check = $this->database
                    ->table(self::TABLE_NAME)
                    ->where(self::COLUMN_NAME, $name)
                    ->fetchAll();
                    
        if(!$check){
        $this->database
            ->table(self::TABLE_NAME)
            ->insert([
                self::COLUMN_NAME => $name,
                self::COLUMN_DESCRIPTION => $description,
                self::COLUMN_PRICE => $price
            ]);
            return true;
        }
        return false;

    }


}