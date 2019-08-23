<?php
/**
 * Name:    Kuzguncuk Codeigniter Language Manage Library
 * Author:  Tolga Keskin
 *          tolgakeskin268@gmail.com
 *
 *
 * Created:  18.08.2019
 *
 * Description:  Codeigniter dil dosyalarını yönetim paneli üzerinden yeni diller ekleyebilir mevcut dilleri düzenleyebilir, yeni anahtar kelimeler ekleyip
 * düzenleyebilir hatta onları silebilirsiniz. Veritabanını sadece dil dosyaları ve anahtarların haritasını oluşturmak için kullanır bu yüzden sistem
 * çalışırken performans kaybı yaşamadan dillerinizi yönetebilirsiniz.
 *
 *
 * @author    		Tolga Keskin
 * @version 		1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Language
{
	protected $CI;

	protected $messages = [];

	protected $errors = [];

	public function __construct()
	{
        // Assign the CodeIgniter super-object
		$this->ci =& get_instance();

		$this->default_lang = 'english';
	}

    /**
     * Yeni dil eklemek için kullanılan fonksiyon hem klasör hem dosya oluşturur.
     *
     * @return json array
     */
    public function create_language($name, $lang)
    {
        // Klasör dosyası yolu
      $lang = strtolower($lang); 

      $dir = FCPATH.'application/language/'.$lang;
      $file_way = $dir.'/main_lang.php';

      if ( ! is_dir($dir))
      {
        mkdir($dir, 0777);
      }
        // Dil var mı sorgula
      $get_lang = $this->ci->db->where('lang_slug',$lang)->get('language')->num_rows();

      if($get_lang > 0)
      {
        $this->set_error($this->__('The name of this language has already been added'));
        return FALSE;
      }

        // Dili veritabanına ekliyoruz. 
      $data = ['lang_name'=>$name,'lang_slug'=> $lang ];

      $insert = $this->ci->db->insert('language', $data);

        // Burada dosyayı oluşturuyorum
      if( ! touch($file_way) && ! $insert)
      {
        $this->set_error($this->__('Error extracting Language File. Database and Write Permission'));
        return FALSE;
      }

        // Eğer başarılıysa içine kayıtlı dosyaları gönderiyoruz.
      $file = fopen($file_way,"w");

      $content = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\r\n";

        // Varsayılan dil olarak ingilizce ayarlaar.
      $default_lang = $this->ci->lang->load('main', $this->default_lang, TRUE);

      foreach ($default_lang as $key)
      {
        $content .= '$lang[\''.$key.'\'] = \'\';';
        $content .= "\r\n";
      }

      fwrite($file, $content);
      fclose($file);

        // Burada yeni dil dosyasını veritabanındaki ekli dil anahtarlarına ekliyoruz.
      $all_key =      $this->ci->db->get('language_key')->result_array();

      foreach ($all_key as $value)
      {
        $value['lk_value'] = unserialize($value['lk_value']);
        $value['lk_value'][$lang] = '';

        $this->ci->db->where('lk_id', $value['lk_id'])->update('language_key', ['lk_value'=> serialize($value['lk_value'])]);
      }

      $this->set_message($this->__('Congratulations Language File Created Successfully.'));
      return TRUE;
    }

    /**
     * Dil dosyasını silmek için kullanılır. 
     * @param int $id Dil Kimliği
     * @return bool
     */
    public function del_lang($id = NULL)
    {
    	$id = (int)$id;

    	if ( ! is_numeric($id) || empty($id))
    	{
    		$this->set_error($this->__('The specified id could not be found'));
    		return FALSE;
    	}


    	$query = $this->ci->db->where('lang_id',$id)->get('language')->row();

    	if ( ! $query)
    	{
    		$this->set_error($this->__('The specified language could not be found.'));
    		return FALSE;
    	}

            // Burada yeni dil dosyasını veritabanındaki ekli dil anahtarlarını siliyoruz.
    	$all_key =  $this->ci->db->get('language_key')->result_array();

    	foreach ($all_key as $value)
    	{
    		$value['lk_value'] = unserialize($value['lk_value']);

    		unset($value['lk_value'][$query->lang_slug]);

        $this->ci->db->where('lk_id', $value['lk_id'])->update('language_key', ['lk_value' => serialize($value['lk_value'])]);
      }

      $del_db = $this->ci->db->delete('language', ['lang_id' => $id]); 
      $del_dir = $this->_del_dir('application/language/'.$query->lang_slug.'/');

      if ($del_dir && $del_db)
      {
        $this->set_message($this->__('The language file was deleted successfully.'));
        return TRUE;
      }

      if ( ! $del_db)
      {
        $this->set_error($this->__('Error deleting language information from database.'));
      }
      if ( ! $del_dir)
      {
        $this->set_error($this->__('Error deleting language folder.'));
      }
      return FALSE;
    }

        /**
        * Yeni dil anahtarı eklemeyi sağlar.
        * 
        * @param  string $key
        * @return mixed array | bool
        */
        public function add_key($key)
        {
        	$all_lang = $this->_get_all_lang();

        	foreach ($all_lang as $value) 
        	{
        		$lang_map[$value['lang_slug']] = '';
        	}

        	$data = [
        		'lk_key'  => $key,
        		'lk_value'=> serialize($lang_map)
        	];
        	$add = $this->ci->db->insert('language_key', $data);

        	if ($add)
        	{
        		$this->set_message($this->__('The language key was created successfully.'));
        		$this->_update_all_lang();
        		return TRUE;
        	}
        	else
        	{
        		$this->set_error($this->__('Error adding language key to database.'));
        		return FALSE;
        	}
        }

        /**
        * Ekli olan dil anahtarını veritabanı ve dil dosyalarından silmeye yarar.
        *
        * @return bool
        */
        public function del_key($id = NULL)
        {
        	$id = (int)$id;

        	if ( ! is_numeric($id) || empty($id)) { return FALSE; }

        	$result = $this->ci->db->delete('language_key', ['lk_id' => $id]); 

        	if($result)
        	{
        		$this->set_message($this->__('The language key was deleted successfully.'));
                // Eğer başarılıysa veritabanından dosyaları tekrar güncelliyoruz.
        		$this->_update_all_lang();
        		return TRUE;
        	}
        	$this->set_error($this->__('Error deleting language key from database.'));
        	return FALSE;
        }

        /**
         * Dil dosyalarını içeriğini görüntüler
         *
         * @param   int $id Dil Kimliği
         * @return  mixed bool | array
         */ 
        public function edit_lang($id = NULL)
        {
        	$id = (int)$id;

        	if ( ! is_numeric($id) || empty($id)) { return FALSE; }

            // İlk önce idye karşılık gelen veritabanında bir dosya var mı kontrol ediyoruz.
        	$query = $this->ci->db->where('lang_id',$id)->get('language')->row();

            if ( ! $query) { return FALSE; } // Böyle bir dil veritabanında ekli değilse geri dön.

            // Eğer varsa veritabanındaki dil adına karşılık gelen klasör varsa böyle bir dil dosyası olduğunu onaylamış oluyoruz.
            $file_way = FCPATH . 'application/language/' . $query->lang_slug . '/main_lang.php';

            if ( ! is_file($file_way)) { return FALSE; } // Böyle bir dil dosyası yoksa geri dön.

            return $query;
          }

        /**
         * Dil dosyalarını içeriğini görüntüler
         *
         * @param   int     $id     Dil Kimliği
         * @param   string  $name   Dil Adı
         * @param   string  $slug   Dil Gerçek Adı
         * @return  bool
         * @todo adını değiştiğim zaman keylerde adı kayboluyor?
         */ 
        public function edit_lang_done($id, $name, $slug)
        {
        	$id = (int)$id;

        	if ( ! is_numeric($id) || empty($id))
        	{
        		$this->set_error($this->__('The Language ID cannot be blank and must be numeric.'));
        		return FALSE;
        	}

        	if (empty($name) || empty($slug))
        	{ 
        		$this->set_error($this->__('Language Name and Language Folder name cannot be left blank.'));
        		return FALSE;
        	}

        	if($this->ci->db->where('lang_id !=',$id)->where('lang_slug', $slug)->get('language')->row())
        	{
        		$this->set_error($this->__('There is already a language for this language name.'));
        		return FALSE;
        	}

        	$get_lang = $this->ci->db->where('lang_id',$id)->get('language')->row();


        	if( ! $get_lang)
        	{
        		$this->set_error($this->__('The language for this ID could not be found.'));
        		return FALSE;
        	}

        	$update = $this->ci->db->where('lang_id', $id)->update('language', ['lang_name' => $name, 'lang_slug' => $slug]);

        	if ( ! $update)
        	{
        		$this->set_error($this->__('An error occurred while updating the Language Name and Language Folder name in the database.'));
        		return FALSE;
        	}

          // Sadece isim değişmişse işlemi tamamla.
          if ( $slug == $get_lang->lang_slug) { goto end; }

          // Language key bilgilerini düzenliyoruz.
          $all_key = $this->ci->db->get('language_key')->result_array();

			    // Yeni gelen lang slug ile eskisi aynı ise silme işlemi yapmıyoruz. 	

          foreach ($all_key as $key)
          {
           $data = unserialize($key['lk_value']);
           $data[$slug] = $data[$get_lang->lang_slug];

           unset($data[$get_lang->lang_slug]);

           $this->ci->db->where('lk_id', $key['lk_id'])->update('language_key', ['lk_value' => serialize($data)]);        		
         }
            // Dil klasör adını güncelliyoruz.
         $dir_way = FCPATH . 'application/language/';

         if (!rename($dir_way.$get_lang->lang_slug, $dir_way.$slug))
         {
          $this->set_error(sprintf($this->__('Language Error changing folder name, please change the folder name to %s manually.')   , $slug));
          return FALSE;
        }

        end:
        $this->set_message($this->__('Language information was updated successfully.'));
        return TRUE;
      }

        /**
        * Dil kelimelerini düzenleme sayfasını gösterir.
        *
        * @param    int    $id      language_key kimliği
        * @return   array  $data    dil anahtar bilgilerini döndürür.
        */
        public function edit_key($id = NULL)
        {
        	$id = (int)$id;

        	if ( ! is_numeric($id) || empty($id)) { return FALSE; }

          $query = $this->ci->db->where('lk_id',$id)->get('language_key')->row();

          $data['lk_id'] = $query->lk_id;
          $data['key']  = $query->lk_key;
          $data['translate'] = unserialize($query->lk_value);

          return $data;
        }

        /**
        * Dil anahtarının çevirisini düzenlemeyi sağlar.
        *
        * @param    int    $id          language_key kimliği
        * @param    string $where       çevirilecek olan dil
        * @param    string $translate   çevirilmiş olan metin
        * @return   bool 
        */
        public function edit_key_value($id = NULL, $where, $translate)
        {
        	$id = (int)$id;

        	if ( ! is_numeric($id) && empty($id) && empty($where)) { return FALSE; } 

        	$language_key = $this->ci->db->where('lk_id',$id)->get('language_key')->row();

        	$lk_value = unserialize($language_key->lk_value);

        	$lk_value[$where] = $translate;

        	$lk_value = serialize($lk_value);

          $update = $this->ci->db->where('lk_id', $id)->update('language_key', ['lk_value'=> $lk_value]);

          if ($update)
          {
                // Son olarak dil dosyalarını veritabanındaki verilerle güncelliyoruz.
            $this->set_message($this->__('Language key successfully updated.'));
            $this->_update_all_lang();
            return TRUE;
          }

          $this->set_error($this->__('Error updating language key in database.'));
          return FALSE;
        }

        /**
         * Mesajları düzenler
         *
         * @param  string $message The message
         * @return string The given message
         */
        public function set_message($message)
        {
        	$this->messages[] = $message;
        	return $message;
        }

        /**
         * Basılan Mesajları Getirir
         *
         * @return string
         */
        public function messages()
        {
        	$_output = '';
        	foreach ($this->messages as $message)
        	{
        		$_output .= $message . "\n";
        	}

        	return $_output;
        }

        /**
         * Hata mesajlarını düzenler
         *
         * @param string $error Hata Mesajını düzenler.
         * @return string Hata mesajı döndürür.
         */
        public function set_error($error)
        {
        	$this->errors[] = $error;
        	return $error;
        }

        /**
         * Get the error message
         *
         * @return string
         */
        public function errors()
        {
                #Düzenle buraya gettext ayarları yapılacak.
        	$_output = '';
        	foreach ($this->errors as $error)
        	{
        		$_output .= $error . "\n";;
        	}
        	return $_output;
        }


        /**
        * @param  string $str Çevrilecek olan metin
        * @param  bool   $log Hata mesajı default false
        * @return string
        */
        public function __($str, $log = TRUE)
        {
        	return $this->ci->lang->line($str, $log);
        }

        /**
        * @param  string $str Çevrilecek olan metin
        * @param  bool   $log Hata mesajı default false
        * @return string
        */
        public function _e($str, $log = TRUE)
        {
        	echo $this->ci->lang->line( $str, $log );
        }

        /**
        * Veritabanındaki tüm dil dosyalarını listeler.
        * @return array
        */
        public function _get_all_key()
        {
        	return  $this->ci->db->get('language_key')->result_array();
        }

        /**
        * Language dosyasındaki klasörleri ve veritabanındaki dosyaları karşılaştırarak her ikisinde ekli olan dil dosyalarını listeler.
        *
        * @return array
        */
        public function _get_all_lang()
        {
        	$all_dir = $this->_show_all_dir();
            // Veritabanındaki tüm dilleri listeliyoruz.
        	$all_lang =  $this->ci->db->get('language')->result_array();

        	$all_name = [];

        	foreach ($all_dir as $value) {
        		foreach ($all_lang as $value2) {
        			if ($value == $value2['lang_slug']) {
        				array_push($all_name, $value2);
        			}
        		}   
        	}
        	return $all_name;
        }

        /**
        * Tüm dil dosyalarını tarayarak veritabanındaki bilgiler ile günceller.
        *
        * @return bool
        */
        public function _update_all_lang()
        {
        	$all_lang = $this->_get_all_lang();

        	if ($all_lang == array()) { return FALSE; }

        	$list_all_key = $this->ci->db->get('language_key')->result();

            // Burada yüklü olan dili include ederek içindeki dil verilerine ulaşıyoruz.
        	foreach ($all_lang as $val2)
        	{
            // @todo: File dosyası kontrol edilip revize edilecek update yada ekleme işlevi 16.08.19

        		$content = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\r\n";

        		foreach ($list_all_key as $list_lang_key)
        		{
        			$array = unserialize($list_lang_key->lk_value);

        			$content .= '$lang[\''.$list_lang_key->lk_key.'\'] = \'' . $array[$val2['lang_slug']] . '\';';
        			$content .= "\r\n";
        		}

        		$new_file_way =  FCPATH.'application/language/'. $val2['lang_slug'] . '/main_lang.php';
        		$file = fopen($new_file_way,"w");   
        		fwrite($file, $content);
        		fclose($file);
        	}
        	return TRUE;
        }

        /**
        * Klasör veya databaselerde klasör yada dil eklenmiş bir diğerinde eklenmemişse hangisinde eklenmediğini gösterir.
        *
        * @return array
        */
        public function _miss_check()
        {
        	$all_dir = $this->_show_all_dir();
            // Veritabanındaki tüm dilleri listeliyoruz.
        	$all_lang_query = $this->ci->db->select('lang_slug')->get('language')->result_array();

         // Gelen verinin farkını öğrenmek için array istediğimiz array formatına getiriyoruz.
        	$all_lang = [];

        	foreach (array_values($all_lang_query) as $value)
        	{
        		array_push($all_lang, $value['lang_slug']);
        	}

            //1.deki array 2.de yok!
        	$miss_lang  =   array_diff($all_dir, $all_lang);
        	$miss_dir   =   array_diff($all_lang, $all_dir);

            // Arrayları stringe çeviriyoruz.
        	$miss_lang  = implode(', ',$miss_lang);
        	$miss_dir   = implode(', ',$miss_dir);

            // Hata mesajlarını ayarlıyoruz.
        	$data['miss_lang']  = NULL;
        	$data['miss_dir']   = NULL;
        	$data['error']      = TRUE;

        	if ($miss_lang)
        	{

        		$data['miss_lang']  =   '<p>'. sprintf($this->__('%s language folders do not appear because they are not added to the language table in the database.'), '<strong>'.$miss_lang.'</strong>') . '</p>';
        	}

        	if ($miss_dir)
        	{
            $data['miss_dir']  =   '<p>'. sprintf($this->__('The %s language attached to the database does not appear because it cannot be found in the application>language folder.'), '<strong>'.$miss_dir.'</strong>') . '</p>';
          }

          if (empty($miss_lang) && empty($miss_dir)) {
            $data['error'] = FALSE;
          }

          return $data;
        }


        /**
        * Tüm dil klasörlerini gösterir.
        *
        *@return array
        */
        public function _show_all_dir()
        {
        	$all_dir=[];

        	foreach(glob(FCPATH.'application/language/*', GLOB_ONLYDIR) as $dir) {
        		array_push($all_dir, basename($dir));
        	}

        	return $all_dir;
        }

        /**
         * Belirtilen klasörü ve içindeki tüm dosyaları tek hamlede silmeyi sağlar.
         *
         * @param string $target
         * @return bool 
         */
        private function _del_dir($target)
        {
        	if(is_dir($target))
        	{
                $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

                foreach( $files as $file )
                {
                	$this->_del_dir( $file );      
                }

                if(!@rmdir( $target ))
                {
                	return FALSE;
                }
                return TRUE;
              }
              elseif(is_file($target))
              {
               unlink( $target );  
             }
           }

         }