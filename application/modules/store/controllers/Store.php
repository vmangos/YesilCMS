<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property General_model $wowgeneral
 * @property Module_model  $wowmodule
 * @property Auth_model    $wowauth
 * @property Template      $template
 * @property Store_model   $store_model
 */
class Store extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('store_model');

        if (! ini_get('date.timezone')) {
            date_default_timezone_set($this->config->item('timezone'));
        }

        if ($this->wowgeneral->getMaintenance()) {
            redirect(base_url('maintenance'), 'refresh');
        }

        if (! $this->wowmodule->getStoreStatus()) {
            redirect(base_url(), 'refresh');
        }

        if (! $this->wowauth->isLogged()) {
            redirect(base_url('login'), 'refresh');
        }

        if (! $this->wowauth->getActivationStatus()) {
            redirect(base_url('pending'));
        }
    }

    public function index()
    {
        $data = array(
            'pagetitle' => $this->lang->line('tab_store'),
            'lang'      => $this->lang->lang()
        );

        $this->template->build('index', $data);
    }

    public function category($route)
    {
        if (empty($route) || is_null($route) || $route == null) {
            redirect(base_url('store'), 'refresh');
        }

        if ($this->store_model->getCategoryExist($route) < 1) {
            redirect(base_url('store'), 'refresh');
        }

        $data = array(
            'route'     => $route,
            'pagetitle' => $this->lang->line('tab_store') . ' | ' . $this->store_model->getCategoryName($route),
            'lang'      => $this->lang->lang()
        );

        $this->template->build('category', $data);
    }

    public function cart()
    {
        $data = array(
            'pagetitle' => $this->lang->line('tab_cart'),
            'lang'      => $this->lang->lang()
        );

        $this->template->build('cart', $data);
    }

    public function addtocart()
    {
        $id = $this->input->post('value');

        $data = array(
            'id'       => $id,
            'name'     => $this->store_model->getName($id),
            'price'    => 0,
            'qty'      => 1,
            'category' => $this->store_model->getCategory($id),
            'guid'     => 0,
            'dp'       => $this->store_model->getPriceDP($id),
            'vp'       => $this->store_model->getPriceVP($id),
            'options'  => array('Key' => uniqid())
        );

        $qq = $this->cart->insert($data);

        echo $qq ? true : false;
    }

    public function removeitem()
    {
        $rowid = $this->input->post('value');
        $qq    = $this->cart->remove($rowid);

        echo $qq ? true : false;
    }

    public function updatequantity()
    {
        $qq    = 0;
        $rowid = $this->input->get('rowid');
        $qty   = $this->input->get('qty');

        if (! empty($rowid) && ! empty($qty)) {
            $data = array(
                'rowid' => $rowid,
                'qty'   => $qty
            );

            $qq = $this->cart->update($data);
        }

        echo $qq ? true : false;
    }

    public function updatecharacter()
    {
        $qq    = 0;
        $rowid = $this->input->get('rowid');
        $guid  = $this->input->get('char');

        if (! empty($rowid) && ! empty($guid)) {
            $data = array(
                'rowid' => $rowid,
                'guid'  => $guid
            );

            $qq = $this->cart->update($data);
        }

        echo $qq ? true : false;
    }

    public function checkout()
    {
        $itemid = $this->input->post('value');

        if ($this->cart->count_items() == $this->cart->valid_items()) {
            echo $this->store_model->Checkout();
        } else {
            echo 'Selchars';
        }
    }
}
