<?php
if (!defined('_PS_VERSION_')) {
  exit;
}
 
class Recommendations extends Module
{
    public function __construct()
    {
      $this->name = 'Recommendations';
      $this->tab = 'advertising_marketing';
      $this->version = '1.0.0';
      $this->author = 'Ja';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;

      parent::__construct();

      $this->displayName = $this->l('Rekomendowane produkty');
      $this->description = $this->l('Rekomendacje produktów dla użytkowników.');
      $this->confirmUninstall = $this->l('Na pewno chcesz odinstalowac?');
      if (!Configuration::get('MYMODULE_NAME')) {
        $this->warning = $this->l('Brak nazwy');
      }
    }

    public function install()
    {
    if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);

      return parent::install() &&
        $this->registerHook('leftColumn') &&
        $this->registerHook('header') &&
        Configuration::updateValue('MYMODULE_NAME', 'Recommendations');
    }

    public function uninstall()
    {
      if (!parent::uninstall()) {
        return false;
      }
       
      return true;
    }

    public function hookDisplayLeftColumn($params)
    {
      $id = Context::getContext()->customer->id;
    $recommendationsJson = file_get_contents("http://172.20.83.78:9090/user/$id/recommendations");
    $recommendationsArray = json_decode($recommendationsJson, true);
    $ids = "";
    if(count($recommendationsArray) > 0){
    foreach ($recommendationsArray as $key => $value) {
      $ids .= $value['itemID'].",";
    }
        $ids = substr($ids, 0, strlen($ids)-1);
        $recommendedProducts = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'product WHERE id IN ('.$ids.')');
          $this->smarty->assign(array(
              'products' => $recommendedProducts,
          ));
      }
      return $this->display(__FILE__, 'product-list.tpl')
    //   return $this->display(__FILE__, 'recommendations.tpl');
    }
    public function hookDisplayRightColumn($params)
    {
      return $this->hookDisplayLeftColumn($params);
    }
    public function hookDisplayHeader()
    {
      $this->context->controller->addCSS($this->_path.'css/mymodule.css', 'all');
    }
    
}