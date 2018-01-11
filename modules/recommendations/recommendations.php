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
}