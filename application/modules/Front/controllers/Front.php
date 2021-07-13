<?php

class Front extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Rest_model');
        $this->load->helper('text');
        $this->load->library('session');
        $this->load->library('phpqrcode/qrlib');
        $this->load->helper('url');
        //  
    }
    public function index(){
        $this->load->view('include-template/header.php');
        $this->load->view('qrcodeview/qrcodetext.php');
        $this->load->view('barcodeview/barcodetext.php');
        $this->load->view('include-template/footer.php');
    }
    public function set_barcode()
    {
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $data=$this->input->post();
        $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/barcode-codeigniter/uploads/';
        $code = strtoupper(preg_replace('/\s+/', '', 'SG_'.$data['ordernumber']).'_'.substr($data['ordernumber'], 1));
        $data['barcode'] = $code;
        // echo "<pre>";
        // print_r($data);
        $file = Zend_Barcode::draw('code128', 'image', array('text'=>$code), array());
        $code = time().$code;
        $store_image = imagepng($file,$SERVERFILEPATH."{$code}.png");
        $file_name1 = $code.'.png';
        $data['imgname'] = $file_name1;
        $this->Rest_model->SaveData('barcode_info', $data);
        // echo "success";
        echo"<center><img src=".base_url().'uploads/'.$file_name1."></center>";
    }

    public function qrcodeGenerator ()
    {


        $qrtext = $this->input->post('qrcode_text');
        
        if(isset($qrtext))
        {

            //file path for store images
            $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/barcode-codeigniter/uploads/';

            $text = $qrtext;
            // $escape_space = str_replace(" ", "_", $text);
            // $text1= substr($escape_space, 0,15);
            
            $folder = $SERVERFILEPATH;
            $file_name1 = "SG_".$text."_" . substr($text, 1) . ".png";
            $file_name = $folder.$file_name1;
            // $customer_url = 'http://www.anupmondal.me/';
            QRcode::png( $file_name1);
            
            echo"<center><img src=".base_url().'uploads/'.$file_name1."></center>";
        }
        else
        {
            echo 'No Text Entered';
        }   
    }
    public function barcode_list(){
        $code = $this->input->post('code');
        $data['adm'] =$this->Rest_model->SelectDataOrder('barcode_info','*','','manu_date', 'desc');
        // echo "<pre>";
        // print_r($data);
        $this->load->view('include-template/header.php');
        $this->load->view('barcodeview/barcode_list', $data);
        $this->load->view('include-template/footer.php');


    }
}