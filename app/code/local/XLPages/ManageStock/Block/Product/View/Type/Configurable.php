<?php
 
class XLPages_ManageStock_Block_Product_View_Type_Configurable  extends Mage_Catalog_Block_Product_View_Type_Configurable
{
    
     
    public function getJsonConfig()
    {
        $attributes = array();
        $options = array();
        $store = Mage::app()->getStore();
        foreach ($this->getAllowProducts() as $product) {
            $productId  = $product->getId();
 
            foreach ($this->getAllowAttributes() as $attribute) {
 
                $productAttribute = $attribute->getProductAttribute();
                $attributeValue = $product->getData($productAttribute->getAttributeCode());
 
                $options['qty'][$product -> getAttributeText($productAttribute->getName())] = floor($product->getStockItem()->getQty());
 
 
                if (!isset($options[$productAttribute->getId()])) {
                    $options[$productAttribute->getId()] = array();
 
                }
                if (!isset($options[$productAttribute->getId()][$attributeValue])) {
                    $options[$productAttribute->getId()][$attributeValue] = array();
 
                }
                $options[$productAttribute->getId()][$attributeValue][] = $productId;
 
            }
        }
 
        $this->_resPrices = array(
        $this->_preparePrice($this->getProduct()->getFinalPrice())
        );
        foreach ($this->getAllowAttributes() as $attribute) {
            $productAttribute = $attribute->getProductAttribute();
            $attributeId = $productAttribute->getId();
 
            $info = array(
            'id'        => $productAttribute->getId(),
            'code'      => $productAttribute->getAttributeCode(),
            'label'     => $attribute->getLabel(),
            'options'   => array()
            );
 
            $optionPrices = array();
            $prices = $attribute->getPrices();
 
            if (is_array($prices)) {
                foreach ($prices as $value) {
                    if(!$this->_validateAttributeValue($attributeId, $value, $options)) {
                        continue;
                    }
                    if($attribute->getLabel() != "Color") {
                        $products= $options[$attributeId][$value['value_index']];
                                                $numItems= count($products)
                        for($i=0;$i $products[$i]);
                            $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($products[$i]);
                            $currentItem = Mage::getModel('catalog/product')->load($products[$i]);
                            $info['options'][] = array(
                            'id'    => $value['value_index'],
                            'label' => ($stockItem->getQty() formatDate($currentItem ->getData('backorder_date')).")" : $value['label'],
                            //'price' => $this->_preparePrice($value['pricing_value'], $value['is_percent']),
                            'price' =>  $this->_registerJsPrice($this->_convertPrice($currentItem ->getData('price'))) - $this->_registerJsPrice($this->_convertPrice($this->getProduct()->getPrice())),
                            'products'   => isset($options[$attributeId][$value['value_index']]) ? $a : array(),
                            );
                        }
                    } else {
                        $info['options'][] = array(
                        'id'    => $value['value_index'],
                        'label' => $value['label'],
                        'price' => $this->_preparePrice($value['pricing_value'], $value['is_percent']),
                        'products'   => isset($options[$attributeId][$value['value_index']]) ? $options[$attributeId][$value['value_index']] : array(),
                        );
                    }
                    $optionPrices[] = $this->_preparePrice($value['pricing_value'], $value['is_percent']);
                }
 
            }
            /**
             * Prepare formated values for options choose
             */
            foreach ($optionPrices as $optionPrice) {
                foreach ($optionPrices as $additional) {
                    $this->_preparePrice(abs($additional-$optionPrice));
                }
            }
            if($this->_validateAttributeInfo($info)) {
                $attributes[$attributeId] = $info;
            }
        }
        $config = array(
        'attributes'=> $attributes,
        'template'  => str_replace('%s', '#{price}', $store->getCurrentCurrency()->getOutputFormat()),
        'prices'    => $this->_prices,
        'basePrice' => $this->_registerJsPrice($this->_convertPrice($this->getProduct()->getFinalPrice())),
        'oldPrice'  => $this->_registerJsPrice($this->_convertPrice($this->getProduct()->getPrice())),
        'productId' => $this->getProduct()->getId(),
        'chooseText'=> Mage::helper('catalog')->__('Choose option...'),
        );
        return Zend_Json::encode($config);
    }
     
    function formatDate($date){
       $_date = explode(" ", $date);
         if($_date[0] != ""){
            return " ~ ".$_date[0];
        }
    }
}
 
?>
