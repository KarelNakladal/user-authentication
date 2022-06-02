<?php 
declare(strict_types=1);

namespace App\Module\Front\Presenters;

use App\Model\ProductFacade;
use Nette\Application\UI\Form;
use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter {

    private $productFacade;

    public function __construct(ProductFacade $productFacade){
        $this->productFacade = $productFacade;
    }

    public function renderDefault(){
        $this->template->products = $this->productFacade->getAll();
    }

    public function createComponentAddProduct(){
        $form = new Form;

        $form->addText('name','Name of the product:')
            ->setRequired();

        $form->addInteger('price', 'Price in CZK:')
            ->setRequired();
            
        $form->addTextArea('description', 'Description of the product:')
            ->setRequired();

        $form->addSubmit('Submit','Add product');

        $form->onSuccess[] = [$this, 'addProductFormSucceeded'];
        return $form;
    }

    public function addProductFormSucceeded($data){
        if($this->productFacade->addProduct($data['name']->value, $data['price']->value, $data['description']->value)){
            $this->flashMessage('New product has been added');
        }else{
            $this->flashMessage('Product with same name cant be added');
        }
    }

}

?>