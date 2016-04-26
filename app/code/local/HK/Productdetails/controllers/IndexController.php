<?php
class HK_Productdetails_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    }
	public function optiondetailsAction()
    {
    	//echo "Hardik patel";
		
		$productId = $_REQUEST['id'];
		/*$productId is your selected product id. do what ever you want to do here.*/
		$product = Mage::getModel('catalog/product')->load($productId);
		$productId = $product->getId();
		$productsku = $product->getSku();
		$productname = $product->getName();
		
		$arraygroup = array("id"=>$productId, "sku"=>$productsku, "name"=>$productname);
		echo json_encode($arraygroup);
    }
	
}