<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**s
* @new_date 26.01.2021
* @author Tolga Keskin
* @version 1.0
*/
class Language_Manage extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		parent::__construct();

		$this->load->library('language');	

		$this->load->language('main', 'english');
		
		if ($this->session->userdata('language'))
		{
			$this->load->language('main', $this->session->userdata('language'));
		}				
	}
	
	public function index()
	{
		$data['get_all']		= $this->language->_get_all_lang();	// Tüm dilleri listeler
		$data['missing_info']	= $this->language->_miss_check();	// Veritabanı ve dosyaları karşılaştırarak eksik varsa listeler.
		$data['get_all_key']	= $this->language->_get_all_key();	// Tüm dil anahtarlarını listeler.

		$this->load->view('language/language_list',$data);
	}

	public function select_language($language = NULL)
	{
		switch ($language)
		{
			case 'turkish':
			$language = 'turkish';
			break;
			default:
			$language = 'english';
			break;
		}
		$this->session->set_userdata('language', $language);

		redirect($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * Yeni dil eklemek için kullanılan fonksiyon hem klasör hem dosya oluşturur.
	 *
	 * @return json array
	 */
	public function create_language()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', $this->lang->line('Language Name'), 'required|trim');
		$this->form_validation->set_rules('lang', $this->lang->line('Language Folder Name'), 'required|trim|alpha_dash');

		$this->_validation();

		$name = $this->input->post('name', TRUE);
		$lang = strtolower($this->input->post('lang', TRUE));

		$result = $this->language->create_language($name, $lang);

		$this->_result($result);
		
	}

	/**
	 * Dil dosyasını silmek için kullanılır. 
	 * @param int $id Dil Kimliği
	 * @return bool
	 */
	public function del_lang($id = NULL)
	{
		if ($id === NULL) { redirect(base_url()); }

		$result =	$this->language->del_lang($id);

		$this->_result($result);
	}

	/**
	 * Dil dosyalarını içeriğini görüntüler
	 *
	 * @param   int $id Dil Kimliği
	 * @return  bool
	 */	
	public function edit_lang($id = NULL)
	{

		if ($id === NULL) { show_404(); }

		$data = $this->language->edit_lang($id);

		if ( ! $data) { show_404(); }
		
		$this->load->view('language/edit_lang', $data);
	}

	/**
	 * Dil dosyalarını içeriğini görüntüler
	 *
	 * @param   int $id Dil Kimliği
	 * @return  bool
	 */	
	public function edit_lang_done($id = NULL)
	{
		$id = (int)$id;

		if ( ! is_numeric($id) || empty($id)) { return FALSE; }

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', $this->lang->line('Language Name'), 'required|trim');
		$this->form_validation->set_rules('slug', $this->lang->line('Language Folder Name'), 'required|trim|alpha_dash'); // @todo is unique sorgusu sqlde yap

		$this->_validation();

		$name = $this->input->post('name', TRUE);
		$slug = $this->input->post('slug', TRUE);

		$result = $this->language->edit_lang_done($id, $name, $slug);

		$this->_result($result);
	}

	/**
	* Yeni dil anahtarı eklemeyi sağlar.
	*
	* @return mixed array | bool
	*/
	public function add_key()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('key', $this->lang->line('Language Key'), 'is_unique[language_key.lk_key]|trim|regex_match[/^([0-9a-zA-ZğüşöçıİĞÜŞÖÇ %_{}<>,.])+$/i]');

		$this->_validation();

		$key = $this->input->post('key', TRUE);

		$result = $this->language->add_key($key);

		$this->_result($result);
	}

	/**
	* Ekli olan dil anahtarını veritabanı ve dil dosyalarından silmeye yarar.
	*
	* @return bool
	*/
	public function del_key($id = NULL)
	{
		$result = $this->language->del_key($id);

		$this->_result($result);
	}

	/**
	* Dil kelimelerini düzenleme sayfasını gösterir.
	*
	* @param 	int    $id 	language_key kimliği
	*/
	public function edit_key($id)
	{
		$data = $this->language->edit_key($id);
		$this->load->view('language/edit_key', $data);
	}

	/**
	* Dil anahtarının çevirisini düzenlemeyi sağlar.
	*
	* @param 	int    $id 	language_key kimliği
	* @param 	string $where	çevirilecek olan dil
	* @return 	bool 
	*/ 
	public function edit_key_value($id = NULL, $where)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('key', $this->lang->line('Language Key'), 'regex_match[/^([0-9a-zA-ZğüşöçıİĞÜŞÖÇ %_{}<>,.])+$/i]');

		$this->_validation();

		$translate = trim($this->input->post('translate', TRUE));

		$result = $this->language->edit_key_value($id, $where, $translate);
		$this->_result($result);
	}

	/**
	 * Gelen sonuçları flash dataya hata veya info olarak yazdırır.
	 *
	 * @param mixed bool | array $result dil kütüphanesinden dönen değer.
	 */
	public function _result($result)
	{
		if ($result)
		{
			$this->session->set_flashdata('info', $this->language->messages());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$this->session->set_flashdata('error', $this->language->errors());
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function _validation()
	{
		if ($this->form_validation->run() === FALSE) 
		{
			$this->session->set_flashdata('error',validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

}