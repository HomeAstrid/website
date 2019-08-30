<?php

class Page extends CI_Controller {
	
    public function index() 
    {
        $this->load->helper('url');
        $this->load->helper('date');
        
        $this->load->library('pagination');
           
        $numrows = $this->db->count_all('tbl_news');
        
        $config['base_url'] = base_url() . "index.php/page/index/";
        $config['total_rows'] = $numrows;
        $config['per_page'] = 5;
        
        $this->pagination->initialize($config);
		
        $this->load->model('User_model', '', TRUE);
		$num = $this->uri->segment(3);
		if($num=="") $num=0;
        $data['query'] = $this->User_model->news_select($config['per_page'], $num);
        
        $this->load->view('headerfile');
        $this->load->view('home', $data);
		$this->load->view('footerfile');
    }
    
	//TODO
    /*public function kalender1($year, $month)
    {
        $this->load->helper('url');
        $prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => 'http://astrid.ugent.be/index.php/page/kalendar/'
             );
        $this->load->library('calendar', $prefs);
        
        if ($this->uri->total_segments() > 2) {
        
        $data = array(
            'year' => $year,
            'month' => $month
        );
        
        }
       
       $this->load->helper('date');
       $this->load->view('headerfile');
       $this->load->view('kalender1', $data);
       $this->load->view('footerfile');
        
    }*/
    
    /*public function kalender()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('kalender');
        $this->load->view('footerfile');
    }*/
	
    public function astrid()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('astrid');
        $this->load->view('footerfile');
    }
    
    public function links()
    {
        
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('links');
        $this->load->view('footerfile');
        
    }
	
    public function geschiedenis()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('geschiedenis');
        $this->load->view('footerfile');
    }
	
    public function bewonerslijst()
    {
        $this->load->helper('url');
        $this->load->helper('date');
		
        $this->load->model('User_model', '', TRUE);
        $data['query'] = $this->User_model->bewlijst_select();
		
        $this->load->view('headerfile');
        $this->load->view('bewonerslijst', $data);
        $this->load->view('footerfile');
    }
	
	public function homeraad()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('homeraad');
        $this->load->view('footerfile');
    }
	
	public function reclame()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('reclame');
        $this->load->view('footerfile');
    }
    
	
	public function statuten()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('statuten');
        $this->load->view('footerfile');
    }
	
	/*public function jenever(){
	
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('jenever');
        $this->load->view('footerfile');
	}
	
	/*public function kaas_wijn(){
	
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('kaas_wijn');
        $this->load->view('footerfile');
	}
	
	public function kaas_wijn2(){
	
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('kaas_wijn2');
        $this->load->view('footerfile');		
	}*/
	public function paintball(){
	
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->view('headerfile');
        $this->load->view('paintball');
        $this->load->view('footerfile');		
	}
    
    function news_disp()
    {
        $this->load->model('User_model', '', TRUE);
        $data['query'] = $this->User_model->news_select();
    }
	
	public function login(){
		$this->load->library('Erkanaauth');
        $this->load->view('headerfile');
        $this->load->view('login');
		$this->load->view('footerfile');
	}
}
?>
