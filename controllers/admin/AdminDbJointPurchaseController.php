<?php

class AdminDbJointPurchaseController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Productos Relacionados'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Producto 1'),
                    'name' => 'related_product_1',
                    'class' => 'fixed-width-xxl',
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Producto 2'),
                    'name' => 'related_product_2',
                    'class' => 'fixed-width-xxl',
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Producto 3'),
                    'name' => 'related_product_3',
                    'class' => 'fixed-width-xxl',
                ],
            ],
            'submit' => [
                'title' => $this->l('Guardar'),
            ],
        ];

        return parent::renderForm();
    }

    public function postProcess()
{
    if (Tools::isSubmit('submitAddconfiguration')) {
        $related_product_1 = (int)Tools::getValue('related_product_1');
        $related_product_2 = (int)Tools::getValue('related_product_2');
        $related_product_3 = (int)Tools::getValue('related_product_3');

        if ($this->productExists($related_product_1) && $this->productExists($related_product_2) && $this->productExists($related_product_3)) {
            Configuration::updateValue('related_product_1', $related_product_1);
            Configuration::updateValue('related_product_2', $related_product_2);
            Configuration::updateValue('related_product_3', $related_product_3);
        } else {
            $this->errors[] = $this->l('Uno o más productos no existen.');
        }
    }

    parent::postProcess();
}

private function productExists($id_product)
{
    $query = new DbQuery();
    $query->select('id_product');
    $query->from('product');
    $query->where('id_product = ' . (int)$id_product);

    return (bool)Db::getInstance()->getValue($query);
}

}